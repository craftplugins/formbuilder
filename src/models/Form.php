<?php

namespace craftplugins\formbuilder\models;

use Craft;
use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\components\Row;
use craftplugins\formbuilder\models\components\traits\ParentTrait;
use Throwable;
use Twig\Markup;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Class Form
 *
 * @package craftplugins\formbuilder\models\components
 * @property string $componentsHtml
 */
class Form extends BaseObject implements ParentInterface
{
    use ParentTrait;

    public const ACTION_NAME = 'formBuilderAction';

    public const HANDLE_NAME = 'formBuilderHandle';

    public const ERRORS_KEY = 'formBuilderValues';

    /**
     * @var string|null
     */
    protected $actionRoute;

    /**
     * @var array
     */
    protected $columnAttributes = ['class' => 'form-column'];

    /**
     * @var array
     */
    protected $componentsAttributes = ['class' => 'form-components'];

    /**
     * @var array|null
     */
    protected $errors;

    /**
     * @var string
     */
    protected $formAction;

    /**
     * @var array
     */
    protected $formAttributes = ['class' => 'form'];

    /**
     * @var string
     */
    protected $formMethod = 'post';

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
    protected $rowAttributes = ['class' => 'form-row'];

    /**
     * @var array|null
     */
    protected $rules;

    /**
     * @var array|null
     */
    protected $values;

    /**
     * Form constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $routeParams = Craft::$app->getUrlManager()->getRouteParams();
        $errors = ArrayHelper::getValue($routeParams, self::ERRORS_KEY);

        if ($errors && $this->getErrors() === null) {
            $this->setErrors($errors);
        }

        $request = Craft::$app->getRequest();

        if ($request->getIsPost()) {
            $generalConfig = Craft::$app->getConfig()->getGeneral();

            try {
                $values = $request->getBodyParams();
                ArrayHelper::remove($values, $generalConfig->actionTrigger);
                ArrayHelper::remove($values, $generalConfig->csrfTokenName);
                ArrayHelper::remove($values, self::ACTION_NAME);
                ArrayHelper::remove($values, self::HANDLE_NAME);

                $this->setValues($values);
            } catch (InvalidConfigException $exception) {
            }
        }
    }

    /**
     * @param string $handle
     * @param array  $config
     *
     * @return static
     */
    public static function create(string $handle, $config = []): self
    {
        $config['handle'] = $handle;

        return new static($config);
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
    public function getComponentsAttributes(): array
    {
        return $this->componentsAttributes;
    }

    /**
     * @param array $componentsAttributes
     */
    public function setComponentsAttributes(array $componentsAttributes): void
    {
        $this->componentsAttributes = $componentsAttributes;
    }

    /**
     * @return string
     */
    public function getComponentsHtml(): string
    {
        $componentTags = [];

        foreach ($this->getComponents() as $component) {
            $componentTags[] = $component->render();
        }

        return implode("\n", $componentTags);
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
     * @return array
     */
    public function getRowAttributes(): array
    {
        return $this->rowAttributes;
    }

    /**
     * @param array $rowAttributes
     */
    public function setRowAttributes(array $rowAttributes): void
    {
        $this->rowAttributes = $rowAttributes;
    }

    /**
     * @return array
     */
    public function getColumnAttributes(): array
    {
        return $this->columnAttributes;
    }

    /**
     * @param array $columnAttributes
     */
    public function setColumnAttributes(array $columnAttributes): void
    {
        $this->columnAttributes = $columnAttributes;
    }

    /**
     * @var array|null
     */
    protected $defaultValues;

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
     * @inheritDoc
     */
    public function getComponents(): array
    {
        $components = $this->components;

        foreach ($components as &$component) {
            if (!$component instanceof Row) {
                $component = Row::create([$component])->setParent($this);
            }
        }

        return $components;
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
     * @return array
     */
    public function getFormAttributes(): array
    {
        return $this->formAttributes;
    }

    /**
     * @param array $formAttributes
     *
     * @return $this
     */
    public function setFormAttributes(array $formAttributes): self
    {
        $this->formAttributes = $formAttributes;

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
            $this->getFormAttributes()
        );

        $pieces[] = Html::actionInput('formbuilder/forms/process');
        $pieces[] = Html::hiddenInput(self::ACTION_NAME, $this->getActionRoute());
        $pieces[] = Html::hiddenInput(self::HANDLE_NAME, $this->getHandle());

        if ($redirectUrl = $this->getRedirectUrl()) {
            $pieces[] = Html::redirectInput($redirectUrl);
        }

        $pieces[] = Html::div(
            $this->getComponentsHtml(),
            $this->getComponentsAttributes()
        );

        $pieces[] = Html::endForm();

        $content = implode("\n", $pieces);
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }
}
