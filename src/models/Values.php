<?php

namespace craftplugins\formbuilder\models;

use Craft;
use yii\base\DynamicModel;

/**
 * Class Values
 *
 * @package craftplugins\formbuilder\models
 * @property array $values
 */
class Values extends DynamicModel
{
    /**
     * @return array
     */
    public function getValues():array
    {
        $csrfTokenName = Craft::$app->getConfig()->getGeneral()->csrfTokenName;

        return $this->getAttributes(null, [
            $csrfTokenName,
            Form::ACTION_NAME,
            Form::RULES_NAME,
        ]);
    }
}
