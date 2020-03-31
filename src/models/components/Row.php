<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\helpers\ArrayHelper;
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
     * @var array
     */
    protected $columnOptions = [];

    /**
     * @var array
     */
    protected $rowOptions = [];

    /**
     * @return array
     */
    public function getColumnOptions(): array
    {
        return ArrayHelper::merge(
            $this->getForm()->getColumnOptions(),
            $this->columnOptions
        );
    }

    /**
     * @param array $columnOptions
     */
    public function setColumnOptions(array $columnOptions): void
    {
        $this->columnOptions = $columnOptions;
    }

    /**
     * @return string
     */
    public function getComponentsHtml(): string
    {
        $columnTags = [];

        foreach ($this->getComponents() as $component) {
            $columnTags[] = Html::div(
                $component->render(),
                $this->getColumnOptions()
            );
        }

        return implode("\n", $columnTags);
    }

    /**
     * @return array
     */
    public function getRowOptions(): array
    {
        return ArrayHelper::merge(
            $this->getForm()->getRowOptions(),
            $this->rowOptions
        );
    }

    /**
     * @param array $rowOptions
     *
     * @return $this
     */
    public function setRowOptions(array $rowOptions): self
    {
        $this->rowOptions = $rowOptions;

        return $this;
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $content = Html::div(
            $this->getComponentsHtml(),
            $this->getRowOptions()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }
}
