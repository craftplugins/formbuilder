<?php

namespace craftplugins\formbuilder\models;

use craftplugins\formbuilder\helpers\ArrayHelper;

/**
 * Class DynamicModel
 *
 * @package craftplugins\formbuilder\models
 */
class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * DynamicModel constructor.
     *
     * @param array $attributes
     * @param array $config
     */
    public function __construct(array $attributes = [], $config = [])
    {
        parent::__construct(
            ArrayHelper::dotAssoc($attributes),
            $config
        );
    }

    /**
     * @param null  $names
     * @param array $except
     *
     * @return array
     */
    public function getAttributes($names = null, $except = []): array
    {
        return ArrayHelper::undot(
            $this->getRawAttributes($names, $except)
        );
    }

    /**
     * @param null $attribute
     *
     * @return array
     */
    public function getErrors($attribute = null): array
    {
        return ArrayHelper::undot(
            $this->getRawErrors($attribute)
        );
    }

    /**
     * @param null  $names
     * @param array $except
     *
     * @return array
     */
    public function getRawAttributes($names = null, $except = []): array
    {
        return parent::getAttributes($names, $except);
    }

    /**
     * @param null $attribute
     *
     * @return array
     */
    public function getRawErrors($attribute = null): array
    {
        return parent::getErrors($attribute);
    }
}
