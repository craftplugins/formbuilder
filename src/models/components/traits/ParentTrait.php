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
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function addComponent(ComponentInterface $component): ParentInterface
    {
        /** @var ParentInterface $this */
        $parent = $this;

        $this->components[] = $component->setParent($parent);

        return $this;
    }

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[] $components
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function addComponents(array $components): ParentInterface
    {
        foreach ($components as $component) {
            $this->addComponent($component);
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
