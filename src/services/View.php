<?php

namespace craftplugins\formbuilder\services;

use Craft;
use craft\base\Component;
use Twig\Markup;

/**
 * Class View
 *
 * @package craftplugins\formbuilder\services
 */
class View extends Component
{
    /**
     * @param $content
     *
     * @return \Twig\Markup
     */
    public function createMarkup($content): Markup
    {
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $content);
    }
}
