<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

/**
 * Class PasswordField
 *
 * @package craftplugins\formbuilder\models\components
 */
class PasswordField extends InputField
{
    /**
     * @var string
     */
    protected $type = 'password';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::input(
            $this->getType(),
            $this->getName(),
            null,
            $this->getInputAttributes()
        );
    }
}
