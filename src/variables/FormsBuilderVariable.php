<?php

namespace craftplugins\formbuilder\variables;

use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\Plugin;
use yii\base\Exception;

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
     */
    public function getForm(array $config): Form
    {
        return new Form($config);
    }

    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\Exception
     */
    public function getFormByHandle(string $handle): Form
    {
        $forms = Plugin::getInstance()->getConfig()->forms;

        if (empty($forms[$handle])) {
            throw new Exception("No form with handle: {$handle}");
        }

        return $forms[$handle];
    }
}
