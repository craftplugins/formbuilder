<?php

namespace craftplugins\formbuilder\models\components\interfaces;

use Twig\Markup;

/**
 * Interface ComponentInterface
 *
 * @package craftplugins\formbuilder\models\components
 */
interface ComponentInterface
{
    /**
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    public function getParent(): ParentInterface;

    /**
     * @return \Twig\Markup
     */
    public function render(): Markup;

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ParentInterface $parent
     *
     * @return $this
     */
    public function setParent(ParentInterface $parent): self;
}
