<?php

namespace craftplugins\formbuilder\models\components\traits;

use craftplugins\formbuilder\models\components\interfaces\ComponentInterface;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;

/**
 * Trait ParentTrait
 *
 * @package craftplugins\formbuilder\models\components\traits
 */
trait ParentTrait
{
    /**
     * @var ComponentInterface[]
     */
    protected $components = [];

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface $component
     * @param null                                                                      $key
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function addComponent(ComponentInterface $component, $key = null): ParentInterface
    {
        /** @var ParentInterface $parent */
        $parent = $this;

        $this->components[$key] = $component->setParent($parent);

        return $this;
    }

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[] $components
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function addComponents(array $components): ParentInterface
    {
        foreach ($components as $key => $component) {
            $this->addComponent($component, $key);
        }

        return $this;
    }

    /**
     * @return \craftplugins\formbuilder\models\components\AbstractComponent[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array $components
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function setComponents(array $components): ParentInterface
    {
        $this->components = [];
        $this->addComponents($components);

        return $this;
    }
}
