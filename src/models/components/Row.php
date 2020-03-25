<?php

namespace craftplugins\formbuilder\models\components;

use Craft;
use craft\helpers\Html;
use craftplugins\formbuilder\models\components\traits\HasComponentsTrait;
use Twig\Markup;

/**
 * Class Row
 *
 * @package craftplugins\formbuilder\models\components
 */
class Row extends AbstractComponent
{
    /**
     * @var array
     */
    protected $rowAttributes = ['class' => 'form-row'];

    /**
     * @param array $components
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\components\AbstractComponent
     */
    public static function create($components = [], $config = []): AbstractComponent
    {
        $instance = new self($config);
        $instance->setComponents($components);

        return $instance;
    }

    use HasComponentsTrait;

    /**
     * @return array
     */
    public function getRowAttributes(): array
    {
        return $this->rowAttributes;
    }

    /**
     * @param array $rowAttributes
     */
    public function setRowAttributes(array $rowAttributes): void
    {
        $this->rowAttributes = $rowAttributes;
    }

    /**
     * @inheritDoc
     */
    public function render(): Markup
    {
        $content = Html::tag(
            'div',
            $this->getComponentsHtml(),
            $this->getRowAttributes()
        );

        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }
}
