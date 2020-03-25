<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;

/**
 * Class SubmitButtonField
 *
 * @package craftplugins\formbuilder\models\components
 */
class SubmitButtonField extends ButtonField
{
    /**
     * @var string
     */
    protected $buttonText = 'Submit';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::submitButton(
            $this->getButtonText(),
            $this->getInputAttributes()
        );
    }
}
