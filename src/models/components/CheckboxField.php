<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;

/**
 * Class CheckboxField
 *
 * @package craftplugins\formbuilder\models\components
 */
class CheckboxField extends InputField
{
    /**
     * @var string|null
     */
    protected $inputLabel;

    /**
     * @var string
     */
    protected $inputType = 'checkbox';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::checkbox(
            $this->getInputName(),
            $this->isChecked(),
            $this->getInputOptions()
        );
    }

    /**
     * @inheritDoc
     */
    public function getInputOptions(): array
    {
        return ArrayHelper::filterAndMerge([
            'label' => $this->getInputLabel(),
        ], parent::getInputOptions());
    }

    /**
     * @return string|null
     */
    public function getInputLabel(): ?string
    {
        return $this->inputLabel;
    }

    /**
     * @param string|null $inputLabel
     */
    public function setInputLabel(?string $inputLabel): void
    {
        $this->inputLabel = $inputLabel;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->getValue() !== null;
    }
}
