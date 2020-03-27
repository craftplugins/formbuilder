<?php

namespace craftplugins\formbuilder\models\components\traits;

/**
 * Trait InputItemsTrait
 *
 * @package craftplugins\formbuilder\models\components\traits
 */
trait InputItemsTrait
{
    /**
     * @var array
     */
    protected $inputItems = [];

    /**
     * @return array
     */
    public function getInputItems(): array
    {
        return $this->inputItems;
    }

    /**
     * @param array $inputItems
     *
     * @return $this
     */
    public function setInputItems(array $inputItems): self
    {
        $this->inputItems = $inputItems;

        return $this;
    }
}
