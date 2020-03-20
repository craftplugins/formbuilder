<?php

namespace craftplugins\formbuilder\models;

use Craft;
use craft\base\Model;
use craft\helpers\ArrayHelper;
use craft\helpers\Html;
use craft\helpers\StringHelper;
use craft\web\View;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;
use yii\base\InvalidConfigException;

/**
 * Class Form
 *
 * @package craftplugins\formbuilder\models
 */
class Form extends Model
{
    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $classPrefix;

    /**
     * @var string
     */
    public $columnClass = 'form-column';

    /**
     * @var array
     */
    public $errors;

    /**
     * @var string
     */
    public $fieldClass = 'form-field';

    /**
     * @var array
     */
    public $fieldDefaults = [];

    /**
     * @var array
     */
    public $fields = [];

    /**
     * @var string
     */
    public $fieldsClass = 'form-fields';

    /**
     * @var string
     */
    public $formAction;

    /**
     * @var string
     */
    public $formMethod = 'post';

    /**
     * @var array
     */
    public $formOptions;

    /**
     * @var string
     */
    public $redirect;

    /**
     * @var string
     */
    public $rowClass = 'form-row';

    /**
     * @var array
     */
    public $rules;

    /**
     * @var array
     */
    public $values;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if ($this->errors === null) {
            // If no errors were supplied try and pull then in via route params
            $routeParams = Craft::$app->getUrlManager()->getRouteParams();
            $this->errors = ArrayHelper::getValue($routeParams, 'formBuilderErrors');
        }
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function __toString()
    {
        return $this->render()->__toString();
    }

    /**
     * @return \Twig\Markup
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $tags = [];

        $tags[] = Html::beginForm($this->formAction, $this->formMethod, $this->formOptions);

        if ($this->rules) {
            $tags[] = Html::actionInput('formbuilder/forms/process');
            $tags[] = Html::hiddenInput('formBuilderAction', $this->action);

            $encodedRules = Plugin::getInstance()->getForms()->encodeRules($this->rules);
            $tags[] = Html::hiddenInput('formBuilderConfig', $encodedRules);
        } elseif ($this->action) {
            $tags[] = Html::actionInput($this->action);
        } else {
            throw new InvalidConfigException('Missing required parameter: action');
        }

        if ($this->redirect) {
            $tags[] = Html::redirectInput($this->redirect);
        }

        $tags[] = $this->renderFieldGroups($this->fields);

        return new Markup(
            implode("\n", $tags),
            $charset = Craft::$app->getView()->getTwig()->getCharset()
        );
    }

    /**
     * @param array  $tagInfo
     * @param string $classPrefix
     * @param array  $exclude
     *
     * @return string
     */
    protected function namespaceClasses(array $tagInfo, string $classPrefix, array $exclude = []): string
    {
        $type = ArrayHelper::getValue($tagInfo, 'type');

        if (!$type || $type === 'text') {
            return ArrayHelper::getValue($tagInfo, 'value');
        }

        $content = '';
        $attributes = ArrayHelper::getValue($tagInfo, 'attributes', []);

        if ($children = ArrayHelper::getValue($tagInfo, 'children')) {
            foreach ($children as $child) {
                $content .= $this->namespaceClasses($child, $classPrefix, $exclude);
            }
        }

        if ($classes = ArrayHelper::getValue($tagInfo, 'class')) {
            $prefixedClasses = [];

            foreach ($classes as $class) {
                if (!in_array($class, $exclude, false)) {
                    $class = StringHelper::ensureLeft($class, $classPrefix);
                }

                $prefixedClasses[] = $class;
            }

            $attributes['class'] = $prefixedClasses;
        }

        return Html::tag($type, $content, $attributes);
    }

    /**
     * @param array $config
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function renderField(array $config): string
    {
        $config = array_replace_recursive($this->fieldDefaults, $config);

        $fieldType = ArrayHelper::getValue($config, 'fieldType', 'textField');
        $label = ArrayHelper::getValue($config, 'label');
        $name = ArrayHelper::getValue($config, 'name');

        if ($name) {
            $config['errors'] = ArrayHelper::getValue($this->errors, $name);
            $config['value'] = ArrayHelper::getValue($this->values, $name);
        }

        switch ($fieldType) {
            case 'button' :
                $content = Html::button($label, $config);
                break;
            case 'reset' :
                $content = Html::resetButton($label, $config);
                break;
            case 'submit' :
                $content = Html::submitButton($label, $config);
                break;
            default :
                $content = $this->renderFormMacro($fieldType, $config);
        }

        if ($this->classPrefix) {
            $excludeClasses = [
                ArrayHelper::getValue($config, 'class'),
                ArrayHelper::getValue($config, 'fieldClass'),
            ];

            $content = $this->namespaceClasses(
                Html::parseTag($content),
                $this->classPrefix,
                $excludeClasses
            );
        }

        $fieldHtml = Html::tag('div', $content, [
            'class' => $this->fieldClass,
        ]);

        return Html::tag('div', $fieldHtml, [
            'class' => $this->columnClass,
        ]);
    }

    /**
     * @param array $fields
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function renderFieldGroup(array $fields): string
    {
        if (ArrayHelper::isAssociative($fields)) {
            $fields = [$fields];
        }

        $tags = [];

        foreach ($fields as $field) {
            $tags[] = $this->renderField($field);
        }

        return Html::tag('div', implode("\n", $tags), [
            'class' => $this->rowClass,
        ]);
    }

    /**
     * @param array $fields
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function renderFieldGroups(array $fields): string
    {
        $tags = [];

        foreach ($fields as $field) {
            $tags[] = $this->renderFieldGroup($field);
        }

        return Html::tag('div', implode("\n", $tags), [
            'class' => $this->fieldsClass,
        ]);
    }

    /**
     * @param string $macro
     * @param array  $config
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    protected function renderFormMacro(string $macro, array $config): string
    {
        $view = Craft::$app->getView();
        $templateMode = $view->getTemplateMode();

        $view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $html = $view->renderTemplateMacro('_includes/forms', $macro, [$config]);

        $view->setTemplateMode($templateMode);

        return $html;
    }
}
