<?php

namespace craftplugins\formbuilder\models\components\traits;

use craftplugins\formbuilder\helpers\ArrayHelper;
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
     * @param bool                                                                      $prepend
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function prependOrAppendComponent(ComponentInterface $component, bool $prepend = false): ParentInterface
    {
        /** @var ParentInterface $parent */
        $parent = $this;

        ArrayHelper::prependOrAppend(
            $this->components,
            $component->setParent($parent),
            $prepend
        );

        return $this;
    }

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[] $components
     * @param bool                                                                        $prepend
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface|\craftplugins\formbuilder\models\components\traits\ParentTrait
     */
    public function prependOrAppendComponents(array $components, bool $prepend = false): ParentInterface
    {
        foreach ($components as $component) {
            $this->prependOrAppendComponent($component, $prepend);
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
        $this->prependOrAppendComponents($components);

        return $this;
    }
}
