<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\ArrayHelper;
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
    protected $controlOptions = ['class' => 'field-control'];

    /**
     * @var array
     */
    protected $errorsOptions = ['class' => 'field-errors'];

    /**
     * @var array
     */
    protected $fieldOptions = ['class' => 'field'];

    /**
     * @var array
     */
    protected $headingOptions = ['class' => 'field-heading'];

    /**
     * @var array|null
     */
    protected $inputOptions = [];

    /**
     * @var array
     */
    protected $instructionsOptions = ['class' => 'field-instructions'];

    /**
     * @var string|null
     */
    protected $instructionsText;

    /**
     * @var array
     */
    protected $labelOptions = ['class' => 'field-label'];

    /**
     * @var string|null
     */
    protected $labelText;

    /**
     * @var string|null
     */
    protected $name;

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
     * @return array
     */
    public function getControlOptions(): array
    {
        return $this->controlOptions;
    }

    /**
     * @param array $controlOptions
     *
     * @return $this
     */
    public function setControlOptions(array $controlOptions): self
    {
        $this->controlOptions = $controlOptions;

        return $this;
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
            $this->getName()
        );
    }

    /**
     * @return array
     */
    public function getErrorsOptions(): array
    {
        return $this->errorsOptions;
    }

    /**
     * @param array $errorsOptions
     *
     * @return $this
     */
    public function setErrorsOptions(array $errorsOptions): self
    {
        $this->errorsOptions = $errorsOptions;

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
     * @return array
     */
    public function getHeadingOptions(): array
    {
        return $this->headingOptions;
    }

    /**
     * @param array $headingOptions
     *
     * @return $this
     */
    public function setHeadingOptions(array $headingOptions): self
    {
        $this->headingOptions = $headingOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function getInputOptions(): array
    {
        return array_merge($this->inputOptions, [
            'id' => $this->getInputId(),
        ]);
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
     * @return array
     */
    public function getInstructionsOptions(): array
    {
        return $this->instructionsOptions;
    }

    /**
     * @param array $instructionsOptions
     *
     * @return $this
     */
    public function setInstructionsOptions(array $instructionsOptions): self
    {
        $this->instructionsOptions = $instructionsOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstructionsText(): ?string
    {
        return $this->instructionsText;
    }

    /**
     * @param string|null $instructionsText
     *
     * @return $this
     */
    public function setInstructionsText(?string $instructionsText): self
    {
        $this->instructionsText = $instructionsText;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabelOptions(): array
    {
        return $this->labelOptions;
    }

    /**
     * @param array $labelOptions
     *
     * @return $this
     */
    public function setLabelOptions(array $labelOptions): self
    {
        $this->labelOptions = $labelOptions;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabelText(): ?string
    {
        return $this->labelText;
    }

    /**
     * @param string|null $labelText
     *
     * @return $this
     */
    public function setLabelText(?string $labelText): self
    {
        $this->labelText = $labelText;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return ArrayHelper::getValue(
            $this->getParent()->getValues() ?? $this->getParent()->getDefaultValues(),
            $this->getName()
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
            $this->getControlOptions()
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
            $this->getErrorsOptions()
        );
    }

    /**
     * @return string
     */
    protected function getHeadingHtml(): string
    {
        $headingTags = [];

        if ($labelText = $this->getLabelText()) {
            $headingTags[] = Html::label(
                $labelText,
                $this->getInputId(),
                $this->getLabelOptions()
            );
        }

        if ($instructionsText = $this->getInstructionsText()) {
            $headingTags[] = Html::div(
                $instructionsText,
                $this->getInstructionsOptions()
            );
        }

        if (empty($headingTags)) {
            return '';
        }

        return Html::div(
            implode("\n", $headingTags),
            $this->getHeadingOptions()
        );
    }

    /**
     * @return string|null
     */
    protected function getInputId(): ?string
    {
        $default = null;

        if ($name = $this->getName()) {
            $default = 'field-' . $name;
        }

        return ArrayHelper::getValue($this->inputOptions, 'id', $default);
    }
}
