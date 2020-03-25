<?php

namespace craftplugins\formbuilder\models\components;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Html;
use Twig\Markup;

/**
 * Class AbstractField
 *
 * @package craftplugins\formbuilder\models\components
 * @property string $errorsHtml
 * @property string $headingHtml
 * @property string $controlHtml
 */
abstract class AbstractField extends AbstractComponent
{
    /**
     * @var array
     */
    protected $controlAttributes = ['class' => 'field-control'];

    /**
     * @var array|null
     */
    protected $errors;

    /**
     * @var array
     */
    protected $errorsAttributes = ['class' => 'field-errors'];

    /**
     * @var array
     */
    protected $fieldAttributes = ['class' => 'field-label'];

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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed|null
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
        return $this->errors;
    }

    /**
     * @param array|null $errors
     *
     * @return $this
     */
    public function setErrors(?array $errors): self
    {
        $this->errors = $errors;

        return $this;
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
     * @return string
     */
    public function getName(): string
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
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed|null $value
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

        $controlHtml = Html::tag(
            'div',
            $this->getControlHtml(),
            $this->getControlAttributes()
        );

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

        $content = Html::tag(
            'div',
            implode(PHP_EOL, $pieces),
            $this->getFieldAttributes()
        );

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

        $listHtml = Html::tag('ul', implode(PHP_EOL, $items));

        return Html::tag(
            'div',
            $listHtml,
            $this->getErrorsAttributes()
        );
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
            $pieces[] = Html::label(
                $labelText,
                $this->getInputId(),
                $this->getLabelAttributes()
            );
        }

        if ($instructionsText) {
            $pieces[] = Html::tag(
                'div',
                $instructionsText,
                $this->getInstructionsAttributes()
            );
        }

        if (empty($pieces)) {
            return '';
        }

        return Html::tag(
            'div',
            implode(PHP_EOL, $pieces),
            $this->getHeadingAttributes()
        );
    }

    /**
     * @return string
     */
    protected function getInputId(): string
    {
        return ArrayHelper::getValue(
            $this->inputAttributes,
            'id',
            'field-' . $this->getName()
        );
    }
}
