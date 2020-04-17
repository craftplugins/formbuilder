<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class HiddenField
 *
 * @package craftplugins\formbuilder\models\components
 */
class HiddenField extends BaseField
{
    /**
     * @var bool
     */
    protected $isGridComponent = false;

    /**
     * @var string
     */
    protected $type = 'hidden';

    /**
     * @inheritDoc
     */
    public function getFieldControlHtml(): string
    {
        $inputs = [];

        foreach ((array) $this->getValue() as $value) {
            $inputs[] = Html::hiddenInput(
                $this->getInputName(),
                $value,
                $this->getInputOptions()
            );
        }

        return implode("\n", $inputs);
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        return Plugin::getInstance()->getView()->createMarkup(
            $this->getFieldControlHtml()
        );
    }
}
