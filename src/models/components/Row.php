<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\traits\HasComponentsTrait;
use Twig\Markup;

class Row extends AbstractComponent
{
    use HasComponentsTrait;

    /**
     * @param array $fields
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\components\AbstractComponent
     */
    public static function create($fields = [], $config = []): AbstractComponent
    {
        $config['fields'] = $fields;

        return parent::create($config);
    }

    /**
     * @inheritDoc
     */
    public function render(): Markup
    {
        return $this->renderComponents();
    }
}
