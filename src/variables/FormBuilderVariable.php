<?php

namespace craftplugins\formbuilder\variables;

use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\Plugin;

/**
 * Class FormBuilderVariable
 *
 * @package craftplugins\formbuilder\variables
 */
class FormBuilderVariable
{
    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormByHandle(string $handle): Form
    {
        return Plugin::getInstance()->getForms()->getFormByHandle($handle);
    }
}
