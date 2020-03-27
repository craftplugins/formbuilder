<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\traits\InputItemsTrait;

/**
 * Class RadioGroupField
 *
 * @package craftplugins\formbuilder\models\components
 */
class RadioGroupField extends BaseField
{
    use InputItemsTrait;

    /**
     * @inheritDoc
     */
    public function getControlHtml(): string
    {
        return Html::radioList(
            $this->getInputName(),
            $this->getValue(),
            $this->getInputItems(),
            $this->getInputOptions()
        );
    }
}
