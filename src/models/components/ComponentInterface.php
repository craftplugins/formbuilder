<?php

namespace craftplugins\formbuilder\models\components;

use Twig\Markup;

/**
 * Interface ComponentInterface
 *
 * @package craftplugins\formbuilder\models\components
 */
interface ComponentInterface
{
    /**
     * @return \Twig\Markup
     */
    public function render(): Markup;
}
