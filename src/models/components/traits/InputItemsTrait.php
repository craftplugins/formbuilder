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
     * @var array|null
     */
    protected $inputItemOptions = ['class' => 'input-item'];

    /**
     * @var array
     */
    protected $inputItems = [];

    /**
     * @return array|null
     */
    public function getInputItemOptions(): ?array
    {
        return $this->inputItemOptions;
    }

    /**
     * @param array|null $inputItemOptions
     */
    public function setInputItemOptions(?array $inputItemOptions): void
    {
        $this->inputItemOptions = $inputItemOptions;
    }

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
