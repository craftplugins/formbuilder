<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

/**
 * Class TextareaField
 *
 * @package craftplugins\formbuilder\models\components
 */
class TextareaField extends BaseField
{
    /**
     * @var string
     */
    protected $type = 'textarea';

    /**
     * @return string
     */
    public function getFieldControlHtml(): string
    {
        return Html::textarea(
            $this->getInputName(),
            $this->getValue(),
            $this->getInputOptions()
        );
    }
}
