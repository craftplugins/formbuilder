<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\StringHelper;
use craftplugins\formbuilder\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class AbstractField
 *
 * @package craftplugins\formbuilder\models\components
 * @property null|string $inputId
 * @property string      $controlHtml
 * @property string      $headingHtml
 * @property string      $errorsHtml
 * @property null|mixed  $value
 * @property null|array  $errors
 */
abstract class AbstractField extends AbstractComponent
{
    /**
     * @var array
     */
    protected $fieldControlOptions = ['class' => 'field-control'];

    /**
     * @var array
     */
    protected $fieldErrorsOptions = ['class' => 'field-errors'];

    /**
     * @var array
     */
    protected $fieldHeadingOptions = ['class' => 'field-heading'];

    /**
     * @var array
     */
    protected $fieldInstructionsOptions = ['class' => 'field-instructions'];

    /**
     * @var string|null
     */
    protected $fieldInstructionsText;

    /**
     * @var array
     */
    protected $fieldLabelOptions = ['class' => 'field-label'];

    /**
     * @var string|null
     */
    protected $fieldLabelText;

    /**
     * @var array
     */
    protected $fieldOptions = ['class' => 'field'];

    /**
     * @var string|null
     */
    protected $inputName;

    /**
     * @var array|null
     */
    protected $inputOptions = ['class' => 'input'];

    /**
     * @param array $config
     *
     * @return static
     */
    public static function create($config = []): self
    {
        return new static($config);
    }

    /**
     * @return string
     */
    abstract public function getControlHtml(): string;

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return ArrayHelper::getValue(
            $this->getParent()->getErrors(),
            $this->getInputName()
        );
    }

    /**
     * @return array
     */
    public function getFieldControlOptions(): array
    {
        return $this->fieldControlOptions;
    }

    /**
     * @param array $fieldControlOptions
     *
     * @return $this
     */
    public function setFieldControlOptions(array $fieldControlOptions): self
    {
        $this->fieldControlOptions = $fieldControlOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldErrorsOptions(): array
    {
        return $this->fieldErrorsOptions;
    }

    /**
     * @param array $fieldErrorsOptions
     *
     * @return $this
     */
    public function setFieldErrorsOptions(array $fieldErrorsOptions): self
    {
        $this->fieldErrorsOptions = $fieldErrorsOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldHeadingOptions(): array
    {
        return $this->fieldHeadingOptions;
    }

    /**
     * @param array $fieldHeadingOptions
     *
     * @return $this
     */
    public function setFieldHeadingOptions(array $fieldHeadingOptions): self
    {
        $this->fieldHeadingOptions = $fieldHeadingOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldInstructionsOptions(): array
    {
        return $this->fieldInstructionsOptions;
    }

    /**
     * @param array $fieldInstructionsOptions
     *
     * @return $this
     */
    public function setFieldInstructionsOptions(array $fieldInstructionsOptions): self
    {
        $this->fieldInstructionsOptions = $fieldInstructionsOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFieldInstructionsText(): ?string
    {
        return $this->fieldInstructionsText;
    }

    /**
     * @param string|null $fieldInstructionsText
     *
     * @return $this
     */
    public function setFieldInstructionsText(?string $fieldInstructionsText): self
    {
        $this->fieldInstructionsText = $fieldInstructionsText;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldLabelOptions(): array
    {
        return $this->fieldLabelOptions;
    }

    /**
     * @param array $fieldLabelOptions
     *
     * @return $this
     */
    public function setFieldLabelOptions(array $fieldLabelOptions): self
    {
        $this->fieldLabelOptions = $fieldLabelOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFieldLabelText(): ?string
    {
        return $this->fieldLabelText;
    }

    /**
     * @param string|null $fieldLabelText
     *
     * @return $this
     */
    public function setFieldLabelText(?string $fieldLabelText): self
    {
        $this->fieldLabelText = $fieldLabelText;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldOptions(): array
    {
        return $this->fieldOptions;
    }

    /**
     * @param array $fieldOptions
     *
     * @return $this
     */
    public function setFieldOptions(array $fieldOptions): self
    {
        $this->fieldOptions = $fieldOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInputName(): ?string
    {
        return $this->inputName;
    }

    /**
     * @param string|null $inputName
     *
     * @return $this
     */
    public function setInputName(?string $inputName): self
    {
        $this->inputName = $inputName;

        return $this;
    }

    /**
     * @return array
     */
    public function getInputOptions(): array
    {
        return ArrayHelper::filterAndMerge([
            'id' => $this->getInputId(),
        ], $this->inputOptions);
    }

    /**
     * @param array $inputOptions
     *
     * @return $this
     */
    public function setInputOptions(array $inputOptions): self
    {
        $this->inputOptions = $inputOptions;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return ArrayHelper::getValue(
            $this->getParent()->getValues() ?? $this->getParent()->getDefaultValues(),
            $this->getInputName()
        );
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $fieldTags = [];

        $fieldTags[] = $this->getHeadingHtml();

        $fieldTags[] = Html::div(
            $this->getControlHtml(),
            $this->getFieldControlOptions()
        );

        if ($this->getErrors()) {
            $fieldTags[] = $this->getErrorsHtml();
        }

        $content = Html::div(
            implode("\n", $fieldTags),
            $this->getFieldOptions()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }

    /**
     * @return string
     */
    protected function getErrorsHtml(): string
    {
        return Html::errors(
            $this->getErrors(),
            $this->getFieldErrorsOptions()
        );
    }

    /**
     * @return string
     */
    protected function getHeadingHtml(): string
    {
        $headingTags = [];

        if ($labelText = $this->getFieldLabelText()) {
            $headingTags[] = Html::label(
                $labelText,
                $this->getInputId(),
                $this->getFieldLabelOptions()
            );
        }

        if ($instructionsText = $this->getFieldInstructionsText()) {
            $headingTags[] = Html::div(
                $instructionsText,
                $this->getFieldInstructionsOptions()
            );
        }

        if (empty($headingTags)) {
            return '';
        }

        return Html::div(
            implode("\n", $headingTags),
            $this->getFieldHeadingOptions()
        );
    }

    /**
     * @return string|null
     */
    protected function getInputId(): ?string
    {
        $default = null;

        if ($name = $this->getInputName()) {
            $default = 'field-' . StringHelper::slugify($name);
        }

        return ArrayHelper::getValue($this->inputOptions, 'id', $default);
    }
}
