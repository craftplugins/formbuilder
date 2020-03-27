<?php

namespace craftplugins\formbuilder\models\components\interfaces;

/**
 * Interface ParentInterface
 *
 * @package craftplugins\formbuilder\models\components
 */
interface ParentInterface
{
    /**
     * @return \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[]
     */
    public function getComponents(): array;

    /**
     * @param array $components
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    public function setComponents(array $components): ParentInterface;
}
