<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

/**
 * Class SelectField
 *
 * @package craftplugins\formbuilder\models\components
 */
class SelectField extends AbstractField
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::dropDownList(
            $this->getName(),
            $this->getValue(),
            $this->getOptions(),
            $this->getInputAttributes()
        );
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
