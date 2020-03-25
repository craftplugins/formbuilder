<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

/**
 * Class InputElement
 *
 * @package craftplugins\formbuilder\models\components
 */
class InputField extends AbstractField
{
    /**
     * @var string
     */
    protected $inputType = 'text';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::input(
            $this->getInputType(),
            $this->getName(),
            $this->getValue(),
            $this->getInputAttributes()
        );
    }

    /**
     * @return string
     */
    public function getInputType(): string
    {
        return $this->inputType;
    }

    /**
     * @param string $inputType
     *
     * @return $this
     */
    public function setInputType(string $inputType): self
    {
        $this->inputType = $inputType;

        return $this;
    }
}
