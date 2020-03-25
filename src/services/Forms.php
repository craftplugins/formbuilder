<?php

namespace craftplugins\formbuilder\services;

use craft\base\Component;
use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\Plugin;
use yii\base\Exception;

/**
 * Class Forms
 *
 * @package craftplugins\formbuilder\services
 */
class Forms extends Component
{
    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\Exception
     */
    public function getFormByHandle(string $handle): Form
    {
        $forms = Plugin::getInstance()->getConfig()->forms;

        if ($form = ArrayHelper::firstWhere($forms, 'handle', $handle)) {
            return $form;
        }

        throw new Exception("No form found with handle: {$handle}");
    }
}
