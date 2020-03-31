<?php

namespace craftplugins\formbuilder\models\components;

use craft\base\Element;
use craft\elements\db\ElementQuery;
use craftplugins\formbuilder\helpers\ArrayHelper;

/**
 * Class ElementsField
 *
 * @package craftplugins\formbuilder\models\components
 * @property callable|null $elementsRenderer
 */
class ElementsField extends InputField
{
    /**
     * @var \craft\elements\db\ElementQuery|null
     */
    protected $elementQuery;

    /**
     * @var callable|null
     */
    protected $elementRenderer;

    /**
     * @var Element[]|null
     */
    protected $elements;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $this->renderAsSelectField();
    }

    /**
     * @return \craft\elements\db\ElementQuery|null
     */
    public function getElementQuery(): ?ElementQuery
    {
        return $this->elementQuery;
    }

    /**
     * @param \craft\elements\db\ElementQuery|null $elementQuery
     *
     * @return $this
     */
    public function setElementQuery(?ElementQuery $elementQuery): self
    {
        $this->elementQuery = $elementQuery;

        return $this;
    }

    /**
     * @return \craft\base\Element[]|null
     */
    public function getElements(): ?array
    {
        $query = $this->getElementQuery();

        if ($this->elements === null && $query !== null) {
            $this->elements = $query->all();
        }

        return $this->elements;
    }

    /**
     * @param array|null $elements
     *
     * @return $this
     */
    public function setElements(?array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }

    /**
     * @return callable|null
     */
    public function getElementsRenderer(): ?callable
    {
        return $this->elementRenderer;
    }

    /**
     * @return string
     */
    public function getFieldControlHtml(): string
    {
        $elements = $this->getElements();
        $renderer = $this->getElementsRenderer();

        if ($elements === null || $renderer === null) {
            return '';
        }

        return $renderer($elements, $this);
    }

    /**
     * @return $this
     */
    public function renderAsCheckboxGroupField(): self
    {
        return $this->setElementsRenderer(static function (array $elements, self $elementsField) {
            return CheckboxGroupField::create()
                ->setInputItems(ArrayHelper::map($elements, 'id', 'title'))
                ->setInputName($elementsField->getInputName())
                ->setInputOptions($elementsField->getInputOptions())
                ->setParent($elementsField->getParent())
                ->getFieldControlHtml();
        });
    }

    /**
     * @return $this
     */
    public function renderAsRadioGroupField(): self
    {
        return $this->setElementsRenderer(static function (array $elements, self $elementsField) {
            return RadioGroupField::create()
                ->setInputItems(ArrayHelper::map($elements, 'id', 'title'))
                ->setInputName($elementsField->getInputName())
                ->setInputOptions($elementsField->getInputOptions())
                ->setParent($elementsField->getParent())
                ->getFieldControlHtml();
        });
    }

    /**
     * @return $this
     */
    public function renderAsSelectField(): self
    {
        return $this->setElementsRenderer(static function (array $elements, self $elementsField) {
            return SelectField::create()
                ->setInputItems(ArrayHelper::map($elements, 'id', 'title'))
                ->setInputName($elementsField->getInputName())
                ->setInputOptions($elementsField->getInputOptions())
                ->setParent($elementsField->getParent())
                ->getFieldControlHtml();
        });
    }

    /**
     * @param callable|null $elementRenderer
     *
     * @return $this
     */
    public function setElementsRenderer(?callable $elementRenderer): self
    {
        $this->elementRenderer = $elementRenderer;

        return $this;
    }
}
