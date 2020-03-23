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
    public const ACTION_NAME = 'formBuilderAction';

    public const HANDLE_NAME = 'formBuilderHandle';

    public const RULES_NAME = 'formBuilderConfig';

    public const VALUES_ROUTE_PARAMS_KEY = 'formBuilderValues';

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
    public $handle;

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
     * Form constructor.
     *
     * @param string|null $handle
     * @param array       $config
     */
    public function __construct(string $handle, array $config = [])
    {
        parent::__construct($config);

        $this->handle = $handle;
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $routeParams = Craft::$app->getUrlManager()->getRouteParams();

        /** @var \craftplugins\formbuilder\models\Values $formBuilderValues */
        $formBuilderValues = ArrayHelper::getValue($routeParams, self::VALUES_ROUTE_PARAMS_KEY);

        if ($formBuilderValues && $this->errors === null) {
            $this->errors = $formBuilderValues->getErrors();
        }

        if ($formBuilderValues) {
            // Override values with submitted values
            $this->values = $formBuilderValues->getValues();
        }
    }

    /**
     * @param string|null $handle
     * @param array       $config
     *
     * @return static
     */
    public static function create(string $handle, array $config = []): self
    {
        return new self($handle, $config);
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
            $tags[] = Html::hiddenInput(self::ACTION_NAME, $this->action);

            if ($this->handle) {
                $tags[] = Html::hiddenInput(self::HANDLE_NAME, $this->handle);
            } else {
                $encodedRules = Plugin::getInstance()->getForms()->encodeRules($this->rules);
                $tags[] = Html::hiddenInput(self::RULES_NAME, $encodedRules);
            }
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
     * @param string $action
     *
     * @return $this
     */
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param string $classPrefix
     *
     * @return $this
     */
    public function setClassPrefix(string $classPrefix): self
    {
        $this->classPrefix = $classPrefix;

        return $this;
    }

    /**
     * @param string $columnClass
     *
     * @return $this
     */
    public function setColumnClass(string $columnClass): self
    {
        $this->columnClass = $columnClass;

        return $this;
    }

    /**
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param string $fieldClass
     *
     * @return $this
     */
    public function setFieldClass(string $fieldClass): self
    {
        $this->fieldClass = $fieldClass;

        return $this;
    }

    /**
     * @param array $fieldDefaults
     *
     * @return $this
     */
    public function setFieldDefaults(array $fieldDefaults): self
    {
        $this->fieldDefaults = $fieldDefaults;

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param string $fieldsClass
     *
     * @return $this
     */
    public function setFieldsClass(string $fieldsClass): self
    {
        $this->fieldsClass = $fieldsClass;

        return $this;
    }

    /**
     * @param string $formAction
     *
     * @return $this
     */
    public function setFormAction(string $formAction): self
    {
        $this->formAction = $formAction;

        return $this;
    }

    /**
     * @param string $formMethod
     *
     * @return $this
     */
    public function setFormMethod(string $formMethod): self
    {
        $this->formMethod = $formMethod;

        return $this;
    }

    /**
     * @param array $formOptions
     *
     * @return $this
     */
    public function setFormOptions(array $formOptions): self
    {
        $this->formOptions = $formOptions;

        return $this;
    }

    /**
     * @param string $redirect
     *
     * @return $this
     */
    public function setRedirect(string $redirect): self
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * @param string $rowClass
     *
     * @return $this
     */
    public function setRowClass(string $rowClass): self
    {
        $this->rowClass = $rowClass;

        return $this;
    }

    /**
     * @param array $rules
     *
     * @return $this
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
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
        $value = ArrayHelper::getValue($config, 'value');

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
            case 'hidden' :
                $content = Html::hiddenInput($name, $value);
                break;
            default :
                $content = $this->renderFormMacro($fieldType, $config);
        }

        if ($this->classPrefix) {
            $excludeClasses = [
                ArrayHelper::getValue($config, 'class'),
                ArrayHelper::getValue($config, 'fieldClass'),
            ];

            // TODO: Classes aren’t being prefixed (needs fixing)
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
