<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;

/**
 * Class RadioField
 *
 * @package craftplugins\formbuilder\models\components
 */
class RadioField extends CheckboxField
{
    /**
     * @var string
     */
    protected $inputType = 'radio';

    /**
     * @return string
     */
    public function getFieldControlHtml(): string
    {
        return Html::radio(
            $this->getInputName(),
            $this->isChecked(),
            $this->getInputOptions()
        );
    }
}
