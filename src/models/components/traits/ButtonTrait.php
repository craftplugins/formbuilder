<?php

namespace craftplugins\formbuilder\models\components\traits;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Trait ButtonTrait
 *
 * @package craftplugins\formbuilder\models\components\traits
 */
trait ButtonTrait
{
    /**
     * @var string
     */
    protected $buttonText = 'Button';

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    /**
     * @param string $buttonText
     *
     * @return $this
     */
    public function setButtonText(string $buttonText): self
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getFieldControlHtml(): string;

    /**
     * @return array
     */
    abstract public function getFieldOptions(): array;

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $content = Html::div(
            $this->getFieldControlHtml(),
            $this->getFieldOptions()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }
}
