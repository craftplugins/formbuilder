<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;
use craft\helpers\StringHelper;

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
        $value = $this->getValue();

        if (StringHelper::toLowerCase($this->getType()) === 'password') {
            $value = null;
        }

        return Html::input(
            $this->getType(),
            $this->getName(),
            $value,
            $this->getInputAttributes()
        );
    }
}
