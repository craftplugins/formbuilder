<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

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
