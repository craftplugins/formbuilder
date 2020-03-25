<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class ButtonField
 *
 * @package craftplugins\formbuilder\models\components
 */
class ButtonField extends AbstractField
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
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $content = Html::div(
            $this->getControlHtml(),
            $this->getFieldAttributes()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::button(
            $this->getButtonText(),
            $this->getInputAttributes()
        );
    }
}
