<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\traits\ButtonTrait;

/**
 * Class ButtonInputField
 *
 * @package craftplugins\formbuilder\models\components
 */
class ButtonInputField extends InputField
{
    use ButtonTrait;

    /**
     * @var string
     */
    protected $inputType = 'button';

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getButtonText();
    }
}
