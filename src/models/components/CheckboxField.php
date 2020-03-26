<?php

namespace craftplugins\formbuilder\models\components;

use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class CheckboxField
 *
 * @package craftplugins\formbuilder\models\components
 */
class CheckboxField extends InputField
{
    /**
     * @var string
     */
    protected $inputType = 'checkbox';

    /**
     * @return string
     */
    public function getControlHtml(): string
    {
        return Html::checkbox(
            $this->getName(),
            $this->isChecked(),
            $this->getInputAttributes()
        );
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $fieldTags = [];

        $fieldTags[] = Html::div(
            $this->getControlHtml(),
            $this->getControlAttributes()
        );

        $fieldTags[] = $this->getHeadingHtml();

        if ($this->getErrors()) {
            $fieldTags[] = $this->getErrorsHtml();
        }

        $fieldHtml = Html::div(
            implode("\n", $fieldTags),
            $this->getFieldAttributes()
        );

        return Plugin::getInstance()->getView()->createMarkup($fieldHtml);
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return ArrayHelper::keyExists(
            $this->getName(),
            $this->getParent()->getValues() ?? $this->getParent()->getDefaultValues()
        );
    }
}
