<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\components\traits\ParentTrait;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class Row
 *
 * @package craftplugins\formbuilder\models\components
 * @property array $values
 * @property array $columnAttributes
 * @property array $errors
 * @property array $rowAttributes
 */
class Row extends AbstractComponent implements ParentInterface
{
    use ParentTrait;

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[] $components
     * @param array                                                                       $config
     *
     * @return \craftplugins\formbuilder\models\components\AbstractComponent
     */
    public static function create(array $components = [], $config = []): AbstractComponent
    {
        $instance = new self($config);
        $instance->setComponents($components);

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function getColumnAttributes(): array
    {
        return $this->getParent()->getColumnAttributes();
    }

    /**
     * @inheritDoc
     */
    public function getRowAttributes(): array
    {
        return $this->getParent()->getRowAttributes();
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): array
    {
        return $this->getParent()->getErrors();
    }

    /**
     * @inheritDoc
     */
    public function getValues(): array
    {
        return $this->getParent()->getValues();
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $content = Html::div(
            $this->getComponentsHtml(),
            $this->getRowAttributes()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }
}
