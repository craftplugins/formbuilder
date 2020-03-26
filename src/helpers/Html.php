<?php

namespace craftplugins\formbuilder\helpers;

/**
 * Class Html
 *
 * @package craftplugins\formbuilder\helpers
 */
class Html extends \craft\helpers\Html
{
    /**
     * @param string $content
     * @param array  $options
     *
     * @return string
     */
    public static function div($content = '', $options = []): string
    {
        return parent::tag('div', $content, $options);
    }

    /**
     * @param array|null $errors
     * @param array      $options
     *
     * @return string
     */
    public static function errors(?array $errors, $options = []): string
    {
        if (empty($errors)) {
            return '';
        }

        return self::div(self::ul($errors), $options);
    }
}
