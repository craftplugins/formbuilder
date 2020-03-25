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
    protected $controlAttributes = ['class' => 'field-control'];

    /**
     * @var array
     */
    protected $errorsAttributes = ['class' => 'field-errors'];

    /**
     * @var array
     */
    protected $fieldAttributes = ['class' => 'field'];

    /**
     * @var array
     */
    protected $headingAttributes = ['class' => 'field-heading'];

    /**
     * @var array|null
     */
    protected $inputAttributes = [];

    /**
     * @var array
     */
    protected $instructionsAttributes = ['class' => 'field-instructions'];

    /**
     * @var string|null
     */
    protected $instructionsText;

    /**
     * @var array
     */
    protected $labelAttributes = ['class' => 'field-label'];

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
    public function getControlAttributes(): array
    {
        return $this->controlAttributes;
    }

    /**
     * @param array $controlAttributes
     *
     * @return $this
     */
    public function setControlAttributes(array $controlAttributes): self
    {
        $this->controlAttributes = $controlAttributes;

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
    public function getErrorsAttributes(): array
    {
        return $this->errorsAttributes;
    }

    /**
     * @param array $errorsAttributes
     *
     * @return $this
     */
    public function setErrorsAttributes(array $errorsAttributes): self
    {
        $this->errorsAttributes = $errorsAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldAttributes(): array
    {
        return $this->fieldAttributes;
    }

    /**
     * @param array $fieldAttributes
     *
     * @return $this
     */
    public function setFieldAttributes(array $fieldAttributes): self
    {
        $this->fieldAttributes = $fieldAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeadingAttributes(): array
    {
        return $this->headingAttributes;
    }

    /**
     * @param array $headingAttributes
     *
     * @return $this
     */
    public function setHeadingAttributes(array $headingAttributes): self
    {
        $this->headingAttributes = $headingAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getInputAttributes(): array
    {
        return array_merge($this->inputAttributes, [
            'id' => $this->getInputId(),
        ]);
    }

    /**
     * @param array $inputAttributes
     *
     * @return $this
     */
    public function setInputAttributes(array $inputAttributes): self
    {
        $this->inputAttributes = $inputAttributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getInstructionsAttributes(): array
    {
        return $this->instructionsAttributes;
    }

    /**
     * @param array $instructionsAttributes
     *
     * @return $this
     */
    public function setInstructionsAttributes(array $instructionsAttributes): self
    {
        $this->instructionsAttributes = $instructionsAttributes;

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
    public function getLabelAttributes(): array
    {
        return $this->labelAttributes;
    }

    /**
     * @param array $labelAttributes
     *
     * @return $this
     */
    public function setLabelAttributes(array $labelAttributes): self
    {
        $this->labelAttributes = $labelAttributes;

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
            $this->getControlAttributes()
        );

        if ($this->getErrors()) {
            $fieldTags[] = $this->getErrorsHtml();
        }

        $content = Html::div(
            implode("\n", $fieldTags),
            $this->getFieldAttributes()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }

    /**
     * @return string
     */
    protected function getErrorsHtml(): string
    {
        if (empty($errors = $this->getErrors())) {
            return '';
        }

        return Html::div(
            Html::ul($errors),
            $this->getErrorsAttributes()
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
                $this->getLabelAttributes()
            );
        }

        if ($instructionsText = $this->getInstructionsText()) {
            $headingTags[] = Html::div(
                $instructionsText,
                $this->getInstructionsAttributes()
            );
        }

        if (empty($headingTags)) {
            return '';
        }

        return Html::div(
            implode("\n", $headingTags),
            $this->getHeadingAttributes()
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

        return ArrayHelper::getValue($this->inputAttributes, 'id', $default);
    }
}
