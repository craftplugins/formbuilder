<?php

namespace craftplugins\formbuilder\models\components;

use Craft;
use craft\helpers\Html;
use Twig\Markup;

/**
 * Class AbstractField
 *
 * @package craftplugins\formbuilder\models\components
 * @property string $controlHtml
 */
abstract class AbstractField extends AbstractComponent
{
    /**
     * @var string
     */
    protected $controlClass = 'field-control';

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $errorsClass = 'field-errors';

    /**
     * @var string
     */
    protected $fieldClass = 'field';

    /**
     * @var string
     */
    protected $headingClass = 'field-heading';

    /**
     * @var array
     */
    protected $inputAttributes = [];

    /**
     * @var string
     */
    protected $inputClass = 'field-input';

    /**
     * @var string
     */
    protected $inputId;

    /**
     * @var string
     */
    protected $instructionsClass = 'field-instructions';

    /**
     * @var string
     */
    protected $instructionsText;

    /**
     * @var string
     */
    protected $labelClass = 'field-label';

    /**
     * @var string
     */
    protected $labelText;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $value;

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
    public function getControlClass(): string
    {
        return $this->controlClass;
    }

    /**
     * @param string $controlClass
     *
     * @return $this
     */
    public function setControlClass(string $controlClass): self
    {
        $this->controlClass = $controlClass;

        return $this;
    }

    abstract public function getControlHtml(): string;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorsClass(): string
    {
        return $this->errorsClass;
    }

    /**
     * @param string $errorsClass
     *
     * @return $this
     */
    public function setErrorsClass(string $errorsClass): self
    {
        $this->errorsClass = $errorsClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getFieldClass(): string
    {
        return $this->fieldClass;
    }

    /**
     * @param string $fieldClass
     *
     * @return $this
     */
    public function setFieldClass(string $fieldClass): self
    {
        $this->fieldClass = $fieldClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeadingClass(): string
    {
        return $this->headingClass;
    }

    /**
     * @param string $headingClass
     *
     * @return $this
     */
    public function setHeadingClass(string $headingClass): self
    {
        $this->headingClass = $headingClass;

        return $this;
    }

    /**
     * @return array
     */
    public function getInputAttributes(): array
    {
        return array_replace_recursive(
            [
                'id' => $this->getInputId(),
                'class' => $this->getInputClass(),
            ],
            $this->getInputAttributes()
        );
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
     * @return string
     */
    public function getInputClass(): string
    {
        return $this->inputClass;
    }

    /**
     * @param string $inputClass
     *
     * @return $this
     */
    public function setInputClass(string $inputClass): self
    {
        $this->inputClass = $inputClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getInputId(): string
    {
        return $this->inputId;
    }

    /**
     * @param string $inputId
     *
     * @return $this
     */
    public function setInputId(string $inputId): self
    {
        $this->inputId = $inputId;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstructionsClass(): string
    {
        return $this->instructionsClass;
    }

    /**
     * @param string $instructionsClass
     *
     * @return $this
     */
    public function setInstructionsClass(string $instructionsClass): self
    {
        $this->instructionsClass = $instructionsClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstructionsText(): string
    {
        return $this->instructionsText;
    }

    /**
     * @param string $instructionsText
     *
     * @return $this
     */
    public function setInstructionsText(string $instructionsText): self
    {
        $this->instructionsText = $instructionsText;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabelClass(): string
    {
        return $this->labelClass;
    }

    /**
     * @param string $labelClass
     *
     * @return $this
     */
    public function setLabelClass(string $labelClass): self
    {
        $this->labelClass = $labelClass;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabelText()
    {
        return $this->labelText;
    }

    /**
     * @param $labelText
     *
     * @return $this
     */
    public function setLabelText($labelText): self
    {
        $this->labelText = $labelText;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return \Twig\Markup
     */
    public function render(): Markup
    {
        $pieces = [];

        $headingHtml = $this->getHeadingHtml();
        $controlHtml = Html::tag('div', $this->getControlHtml(), [
            'class' => $this->getControlClass(),
        ]);

        if (in_array($this->getType(), ['checkbox', 'radio'])) {
            $pieces[] = $controlHtml;
            $pieces[] = $headingHtml;
        } else {
            $pieces[] = $headingHtml;
            $pieces[] = $controlHtml;
        }

        if ($this->getErrors()) {
            $pieces[] = $this->getErrorsHtml();
        }

        $content = implode(PHP_EOL, $pieces);
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }

    /**
     * @return string
     */
    protected function getErrorsHtml(): string
    {
        $items = [];

        foreach ($this->getErrors() as $error) {
            $items[] = Html::tag('li', $error);
        }

        if (empty($items)) {
            return '';
        }

        $list = Html::tag('ul', implode(PHP_EOL, $items));

        return Html::tag('div', $list, [
            'class' => $this->getErrorsClass(),
        ]);
    }

    /**
     * @return string
     */
    protected function getHeadingHtml(): string
    {
        $instructionsText = $this->getInstructionsText();
        $labelText = $this->getLabelText();

        $pieces = [];

        if ($labelText) {
            $pieces[] = Html::label($labelText, $this->getInputId(), [
                'class' => $this->getLabelClass(),
            ]);
        }

        if ($instructionsText) {
            $pieces[] = Html::tag('div', $instructionsText, [
                'class' => $this->getLabelClass(),
            ]);
        }

        if (empty($pieces)) {
            return '';
        }

        return implode(PHP_EOL, $pieces);
    }
}
