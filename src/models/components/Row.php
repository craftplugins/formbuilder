<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\traits\HasComponentsTrait;
use Twig\Markup;

/**
 * Class Row
 *
 * @package craftplugins\formbuilder\models\components
 */
class Row extends AbstractComponent
{
    use HasComponentsTrait;

    /**
     * @param array $components
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\components\AbstractComponent
     */
    public static function create($components = [], $config = []): AbstractComponent
    {
        $instance = new self($config);
        $instance->setComponents($components);

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function render(): Markup
    {
        return $this->renderComponents();
    }
}
