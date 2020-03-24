<?php

namespace craftplugins\formbuilder\models\components;

use yii\base\BaseObject;

/**
 * Class AbstractComponent
 *
 * @package craftplugins\formbuilder\models\components
 */
abstract class AbstractComponent extends BaseObject implements ComponentInterface
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->render();
    }
}
