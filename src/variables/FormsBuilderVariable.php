<?php

namespace craftplugins\formbuilder\variables;

use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\Plugin;

/**
 * Class FormsBuilderVariable
 *
 * @package craftplugins\formbuilder\variables
 */
class FormsBuilderVariable
{
    /**
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\InvalidConfigException
     */
    public function createForm(array $config): Form
    {
        return Plugin::getInstance()->getForms()->createForm($config);
    }

    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\Exception
     */
    public function getFormByHandle(string $handle): Form
    {
        return Plugin::getInstance()->getForms()->getFormByHandle($handle);
    }
}
