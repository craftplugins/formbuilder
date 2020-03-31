<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;
use craftplugins\formbuilder\models\components\traits\InputItemsTrait;

/**
 * Class SelectField
 *
 * @package craftplugins\formbuilder\models\components
 */
class SelectField extends BaseField
{
    use InputItemsTrait;

    /**
     * @var array|null
     */
    protected $inputOptions = ['class' => 'input', 'prompt' => ' '];

    /**
     * @return string
     */
    public function getFieldControlHtml(): string
    {
        return Html::dropDownList(
            $this->getInputName(),
            $this->getValue(),
            $this->getInputItems(),
            $this->getInputOptions()
        );
    }
}
