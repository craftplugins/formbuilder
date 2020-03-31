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
     * @param        $array
     * @param string $prepend
     *
     * @return array
     */
    public static function dot($array, $prepend = ''): array
    {
        return Arr::dot($array, $prepend);
    }

    /**
     * @param        $array
     * @param string $prepend
     *
     * @return array
     */
    public static function dotAssoc($array, $prepend = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (self::isAssociative($value)) {
                $results = self::merge($results, self::dotAssoc($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
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
