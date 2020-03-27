<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class Row
 *
 * @package craftplugins\formbuilder\models\components
 * @property string $componentsHtml
 */
class Row extends BaseFieldGroup
{
    /**
     * @return string
     */
    public function getComponentsHtml(): string
    {
        $columnTags = [];

        foreach ($this->getComponents() as $component) {
            $columnTags[] = Html::div(
                $component->render(),
                $this->getForm()->getColumnOptions()
            );
        }

        return implode("\n", $columnTags);
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $content = Html::div(
            $this->getComponentsHtml(),
            $this->getForm()->getRowOptions()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }
}
