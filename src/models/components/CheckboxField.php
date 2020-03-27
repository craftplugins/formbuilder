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
     * @var array|null
     */
    protected $inputLabelOptions = ['class' => 'input-label'];

    /**
     * @var string|null
     */
    protected $inputLabelText;

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
            'label' => $this->getInputLabelText(),
            'labelOptions' => $this->getInputLabelOptions(),
        ], parent::getInputOptions());
    }

    /**
     * @return array|null
     */
    public function getInputLabelOptions(): ?array
    {
        return $this->inputLabelOptions;
    }

    /**
     * @param array|null $inputLabelOptions
     */
    public function setInputLabelOptions(?array $inputLabelOptions): void
    {
        $this->inputLabelOptions = $inputLabelOptions;
    }

    /**
     * @return string|null
     */
    public function getInputLabelText(): ?string
    {
        return $this->inputLabelText;
    }

    /**
     * @param string|null $inputLabelText
     *
     * @return $this
     */
    public function setInputLabelText(?string $inputLabelText): self
    {
        $this->inputLabelText = $inputLabelText;

        return $this;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->getValue() !== null;
    }
}
