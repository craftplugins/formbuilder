<?php

namespace craftplugins\formbuilder\helpers;

use Tightenco\Collect\Support\Arr;

/**
 * Class ArrayHelper
 *
 * @package craftplugins\formbuilder\helpers
 */
class ArrayHelper extends \craft\helpers\ArrayHelper
{
    /**
     * @param $array
     *
     * @return array
     */
    public static function dot($array): array
    {
        return Arr::dot($array);
    }

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

    /**
     * @param $array
     *
     * @return array
     */
    public static function undot($array): array
    {
        $return = [];

        foreach ($array as $key => $value) {
            Arr::set($return, $key, $value);
        }

        return $return;
    }
}
