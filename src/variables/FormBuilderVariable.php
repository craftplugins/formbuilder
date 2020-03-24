<?php

namespace craftplugins\formbuilder\variables;

use craftplugins\formbuilder\models\components\Form;
use craftplugins\formbuilder\Plugin;

/**
 * Class FormBuilderVariable
 *
 * @package craftplugins\formbuilder\variables
 */
class FormBuilderVariable
{
    /**
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\components\Form
     * @throws \yii\base\InvalidConfigException
     */
    public function createForm(array $config): Form
    {
        return Plugin::getInstance()->getForms()->createForm($config);
    }

    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\components\Form
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormByHandle(string $handle): Form
    {
        return Plugin::getInstance()->getForms()->getFormByHandle($handle);
    }
}
