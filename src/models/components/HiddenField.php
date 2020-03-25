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
class HiddenField extends AbstractField
{
    /**
     * @var string
     */
    protected $type = 'hidden';

    /**
     * @inheritDoc
     */
    public function getControlHtml(): string
    {
        return Html::hiddenInput(
            $this->getName(),
            $this->getValue(),
            $this->getInputAttributes()
        );
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        return Plugin::getInstance()->getView()->createMarkup(
            $this->getControlHtml()
        );
    }
}
