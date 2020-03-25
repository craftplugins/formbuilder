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
     * @var bool
     */
    protected $checked;

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

        $content = Html::div(
            Html::div(
                implode("\n", $fieldTags),
                $this->getFieldAttributes()
            ),
            $this->getParent()->getColumnAttributes()
        );

        return Plugin::getInstance()->getView()->createMarkup($content);
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        $values = $this->getParent()->getValues();

        if ($values) {
            return ArrayHelper::keyExists($this->getName(), $values);
        }

        return $this->checked;
    }

    /**
     * @param bool $checked
     */
    public function setChecked(bool $checked): void
    {
        $this->checked = $checked;
    }
}
