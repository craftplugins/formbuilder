<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\interfaces\ComponentInterface;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use yii\base\BaseObject;

/**
 * Class AbstractComponent
 *
 * @package craftplugins\formbuilder\models\components
 */
abstract class AbstractComponent extends BaseObject implements ComponentInterface
{
    /**
     * @var \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    protected $parent;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->render();
    }

    /**
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    public function getParent(): ParentInterface
    {
        return $this->parent;
    }

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ParentInterface $parent
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ComponentInterface
     */
    public function setParent(ParentInterface $parent): ComponentInterface
    {
        $this->parent = $parent;

        return $this;
    }
}
