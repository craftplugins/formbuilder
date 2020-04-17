<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\interfaces\ComponentInterface;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\Form;
use yii\base\BaseObject;

/**
 * Class AbstractComponent
 *
 * @package craftplugins\formbuilder\models\components
 */
abstract class AbstractComponent extends BaseObject implements ComponentInterface
{
    /**
     * @var \craftplugins\formbuilder\models\Form
     */
    protected $form;

    /**
     * @var bool
     */
    protected $isGridComponent = true;

    /**
     * @var ParentInterface
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
     * @return \craftplugins\formbuilder\models\Form
     */
    public function getForm(): Form
    {
        /** @var Form $parent */
        $parent = $this->getParent();

        // Traverse up the tree until we reach the form
        while ($parent instanceof Form === false) {
            /** @var ComponentInterface $parent */
            $parent = $parent->getParent();
        }

        return $parent;
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
     * @return $this
     */
    public function setParent(ParentInterface $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return bool
     */
    public function isGridComponent(): bool
    {
        return $this->isGridComponent;
    }

    /**
     * @param bool $isGridComponent
     */
    public function setIsGridComponent(bool $isGridComponent): void
    {
        $this->isGridComponent = $isGridComponent;
    }
}
