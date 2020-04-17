<?php

namespace craftplugins\formbuilder\models;

use Craft;
use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\components\Row;
use craftplugins\formbuilder\models\components\traits\ParentTrait;
use Twig\Markup;
use yii\base\BaseObject;

/**
 * Class Form
 *
 * @package craftplugins\formbuilder\models
 * @property string $componentsHtml
 */
class Form extends BaseObject implements ParentInterface
{
    use ParentTrait;

    public const ACTION_NAME = 'formBuilderAction';

    public const HANDLE_NAME = 'formBuilderHandle';

    public const VALUES_KEY = 'formBuilderValues';

    /**
     * @var string|null
     */
    protected $actionRoute;

    /**
     * @var bool
     */
    protected $actionRunWithErrors = false;

    /**
     * @var array
     */
    protected $columnOptions = ['class' => ['form-column']];

    /**
     * @var array
     */
    protected $componentsOptions = ['class' => ['form-components']];

    /**
     * @var array|null
     */
    protected $defaultValues;

    /**
     * @var array|null
     */
    protected $errors;

    /**
     * @var string
     */
    protected $formAction;

    /**
     * @var array|null
     */
    protected $formErrors;

    /**
     * @var string
     */
    protected $formMethod = 'post';

    /**
     * @var array
     */
    protected $formOptions = ['class' => ['form']];

    /**
     * @var string|null
     */
    protected $handle;

    /**
     * @var string|null
     */
    protected $redirectUrl;

    /**
     * @var array
     */
    protected $rowOptions = ['class' => ['form-row']];

    /**
     * @var array|null
     */
    protected $rules;

    /**
     * @var array|null
     */
    protected $values;

    /**
     * @param string $handle
     * @param array  $config
     *
     * @return static
     */
    public static function create(string $handle, $config = []): self
    {
        $instance = new static($config);

        return $instance->setHandle($handle);
    }

    /**
     * @param array|null $errors
     *
     * @return $this
     */
    public function addErrors(?array $errors): self
    {
        if ($errors === null) {
            return $this;
        }

        $mergedErrors = array_merge_recursive(
            $this->getErrors() ?? [],
            $errors
        );

        return $this->setErrors($mergedErrors);
    }

    /**
     * @param array|null $values
     *
     * @return $this
     */
    public function addValues(?array $values): self
    {
        if ($values === null) {
            return $this;
        }

        $mergedValues = array_merge_recursive(
            $this->getValues() ?? [],
            $values
        );

        return $this->setValues($mergedValues);
    }

    /**
     * @return string|null
     */
    public function getActionRoute(): ?string
    {
        return $this->actionRoute;
    }

    /**
     * @param string|null $actionRoute
     *
     * @return $this
     */
    public function setActionRoute(?string $actionRoute): self
    {
        $this->actionRoute = $actionRoute;

        return $this;
    }

    /**
     * @return array
     */
    public function getColumnOptions(): array
    {
        return $this->columnOptions;
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getComponentsHtml(): string
    {
        $componentTags = [];

        foreach ($this->getComponents() as $component) {
            if ($component instanceof Row === false && $component->isGridComponent()) {
                $component = Row::create([$component])->setParent($this);
            }

            $componentTags[] = $component->render();
        }

        return implode("\n", $componentTags);
    }

    /**
     * @return array
     */
    public function getComponentsOptions(): array
    {
        return $this->componentsOptions;
    }

    /**
     * @param array $componentsOptions
     */
    public function setComponentsOptions(array $componentsOptions): void
    {
        $this->componentsOptions = $componentsOptions;
    }

    /**
     * @return array|null
     */
    public function getDefaultValues(): ?array
    {
        return $this->defaultValues;
    }

    /**
     * @param array|null $defaultValues
     *
     * @return $this
     */
    public function setDefaultValues(?array $defaultValues): self
    {
        $this->defaultValues = $defaultValues;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * @param array|null $errors
     *
     * @return $this
     */
    public function setErrors(?array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormAction(): ?string
    {
        return $this->formAction;
    }

    /**
     * @param string|null $formAction
     *
     * @return $this
     */
    public function setFormAction(?string $formAction): self
    {
        $this->formAction = $formAction;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFormErrors(): ?array
    {
        return $this->formErrors;
    }

    /**
     * @param array|null $formErrors
     *
     * @return $this
     */
    public function setFormErrors(?array $formErrors): self
    {
        $this->formErrors = $formErrors;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormMethod(): string
    {
        return $this->formMethod;
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
     * @return array
     */
    public function getFormOptions(): array
    {
        return ArrayHelper::merge([
            'enctype' => 'multipart/form-data',
        ], $this->formOptions);
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
     * @return string|null
     */
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @param string|null $handle
     *
     * @return $this
     */
    public function setHandle(?string $handle): self
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string|null $redirectUrl
     *
     * @return $this
     */
    public function setRedirectUrl(?string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * @return array
     */
    public function getRowOptions(): array
    {
        return $this->rowOptions;
    }

    /**
     * @param array $rowOptions
     */
    public function setRowOptions(array $rowOptions): void
    {
        $this->rowOptions = $rowOptions;
    }

    /**
     * @return array|null
     */
    public function getRules(): ?array
    {
        return $this->rules;
    }

    /**
     * @param array|null $rules
     *
     * @return $this
     */
    public function setRules(?array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * @param array|null $values
     *
     * @return $this
     */
    public function setValues(?array $values): self
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActionRunWithErrors(): bool
    {
        return $this->actionRunWithErrors;
    }

    /**
     * @param bool $actionRunWithErrors
     *
     * @return $this
     */
    public function setActionRunWithErrors(bool $actionRunWithErrors = true): self
    {
        $this->actionRunWithErrors = $actionRunWithErrors;

        return $this;
    }

    /**
     * @return $this
     */
    public function populateParams(): self
    {
        $routeParams = Craft::$app->getUrlManager()->getRouteParams();

        /** @var \yii\base\DynamicModel $model */
        $model = ArrayHelper::getValue($routeParams, self::VALUES_KEY);

        if ($model === null) {
            return $this;
        }

        $generalConfig = Craft::$app->getConfig()->getGeneral();

        $modelValues = $model->getAttributes(null, [
            $generalConfig->actionTrigger,
            $generalConfig->csrfTokenName,
            self::ACTION_NAME,
            self::HANDLE_NAME,
        ]);
        $this->setValues($modelValues);

        $this->setErrors($model->getErrors());

        return $this;
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $pieces = [];

        $pieces[] = Html::beginForm(
            $this->getFormAction(),
            $this->getFormMethod(),
            $this->getFormOptions()
        );

        if ($actionRoute = $this->getActionRoute()) {
            $pieces[] = Html::actionInput('formbuilder/forms/process');
            $pieces[] = Html::hiddenInput(self::ACTION_NAME, $actionRoute);
            $pieces[] = Html::hiddenInput(self::HANDLE_NAME, $this->getHandle());
        }

        if ($redirectUrl = $this->getRedirectUrl()) {
            $pieces[] = Html::redirectInput($redirectUrl);
        }

        if ($formErrors = $this->getFormErrors()) {
            $pieces[] = Html::errors($formErrors);
        }

        $pieces[] = Html::div(
            $this->getComponentsHtml(),
            $this->getComponentsOptions()
        );

        $pieces[] = Html::endForm();

        $content = implode("\n", $pieces);
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }
}
