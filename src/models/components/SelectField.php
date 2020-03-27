<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;
use craftplugins\formbuilder\models\components\traits\InputItemsTrait;

/**
 * Class SelectField
 *
 * @package craftplugins\formbuilder\models\components
 */
class SelectField extends AbstractField
{
    use InputItemsTrait;

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::dropDownList(
            $this->getInputName(),
            $this->getValue(),
            $this->getInputItems(),
            $this->getInputOptions()
        );
    }
}
