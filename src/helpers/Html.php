<?php

namespace craftplugins\formbuilder\helpers;

use craftplugins\formbuilder\models\components\AbstractField;

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
     * @param \craftplugins\formbuilder\models\components\AbstractField $field
     *
     * @return string
     */
    public static function fieldColumn(AbstractField $field):string
    {
        return self::div(
            self::div(
                $field->getControlHtml(),
                $field->getFieldAttributes()
            ),
            $field->getParent()->getColumnAttributes()
        );
    }
}
