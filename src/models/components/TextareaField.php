<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;

/**
 * Class TextareaField
 *
 * @package craftplugins\formbuilder\models\components
 */
class TextareaField extends AbstractField
{
    /**
     * @var string
     */
    protected $type = 'textarea';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::textarea(
            $this->getName(),
            $this->getValue(),
            $this->getInputAttributes()
        );
    }
}
