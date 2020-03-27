<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\traits\InputItemsTrait;

/**
 * Class CheckboxGroupField
 *
 * @package craftplugins\formbuilder\models\components
 */
class CheckboxGroupField extends BaseField
{
    use InputItemsTrait;

    /**
     * @inheritDoc
     */
    public function getFieldControlHtml(): string
    {
        return Html::checkboxList(
            $this->getInputName(),
            $this->getValue(),
            $this->getInputItems(),
            $this->getInputOptions()
        );
    }

    /**
     * @return array
     */
    public function getInputOptions(): array
    {
        return ArrayHelper::filterAndMerge([
            'itemOptions' => $this->getInputItemOptions(),
        ], parent::getInputOptions());
    }
}
