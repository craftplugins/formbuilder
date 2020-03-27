<?php

namespace craftplugins\formbuilder\helpers;

class ArrayHelper extends \craft\helpers\ArrayHelper
{
    /**
     * @param mixed ...$arrays
     *
     * @return array
     */
    public static function filterAndMerge(...$arrays): array
    {
        return static::merge(
            ...array_map('array_filter', $arrays)
        );
    }
}
