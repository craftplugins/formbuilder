<?php

namespace craftplugins\formbuilder\models;

use craft\base\Model;

/**
 * Class Config
 *
 * @package craftplugins\formbuilder\models
 */
class Config extends Model
{
    /**
     * @var \craftplugins\formbuilder\models\components\Form[]|array
     */
    public $forms = [];
}
