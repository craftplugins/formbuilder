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
     * @return array
     */
    public function getColumnAttributes(): array;

    /**
     * @return \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[]
     */
    public function getComponents(): array;

    /**
     * @return array|null
     */
    public function getDefaultValues(): ?array;

    /**
     * @return array|null
     */
    public function getErrors(): ?array;

    /**
     * @return array
     */
    public function getRowAttributes(): array;

    /**
     * @return array|null
     */
    public function getValues(): ?array;

    /**
     * @param array $components
     *
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    public function setComponents(array $components): ParentInterface;
}
