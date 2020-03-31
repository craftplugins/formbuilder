<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\traits\ButtonTrait;

/**
 * Class ButtonField
 *
 * @package craftplugins\formbuilder\models\components
 */
class ButtonField extends BaseField
{
    use ButtonTrait;

    /**
     * @return string
     */
    public function getFieldControlHtml(): string
    {
        return Html::button(
            $this->getButtonText(),
            $this->getInputOptions()
        );
    }
}
