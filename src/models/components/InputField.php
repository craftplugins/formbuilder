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
    protected $type = 'text';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::input(
            $this->getType(),
            $this->getName(),
            $this->getValue(),
            $this->getInputAttributes()
        );
    }
}
