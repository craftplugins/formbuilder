<?php

namespace craftplugins\formbuilder\models\components;

use Craft;
use craft\helpers\ArrayHelper;
use craft\helpers\Html;
use craftplugins\formbuilder\models\components\traits\HasComponentsTrait;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class Form
 *
 * @package craftplugins\formbuilder\models\components
 */
class Form extends AbstractComponent
{
    use HasComponentsTrait;

    public const ACTION_NAME = 'formBuilderAction';

    public const HANDLE_NAME = 'formBuilderHandle';

    public const RULES_NAME = 'formBuilderRules';

    public const VALUES_KEY = 'formBuilderValues';

    /**
     * @var string
     */
    protected $actionRoute;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $formAction;

    /**
     * @var array
     */
    protected $formAttributes = [];

    /**
     * @var string
     */
    protected $formClass = 'form';

    /**
     * @var string
     */
    protected $formId;

    /**
     * @var string
     */
    protected $formMethod = 'post';

    /**
     * @var string
     */
    protected $handle;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var array
     */
    protected $rules;

    /**
     * @var array
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

        // Get any route params set by the controller
        $routeParams = Craft::$app->getUrlManager()->getRouteParams();

        /** @var \yii\base\DynamicModel $dynamicModel */
        $dynamicModel = ArrayHelper::getValue($routeParams, self::VALUES_KEY);

        if ($dynamicModel && $this->getErrors() === null) {
            // Set errors from
            $this->setErrors(
                $dynamicModel->getErrors()
            );
        }

        if ($dynamicModel) {
            // Override values with submitted values
            $this->setValues(
                $dynamicModel->getAttributes(null, [
                    Craft::$app->getConfig()->getGeneral()->csrfTokenName,
                    self::ACTION_NAME,
                    self::RULES_NAME,
                ])
            );
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
     * @return mixed
     */
    public function getActionRoute()
    {
        return $this->actionRoute;
    }

    /**
     * @param $actionRoute
     *
     * @return $this
     */
    public function setActionRoute(string $actionRoute): self
    {
        $this->actionRoute = $actionRoute;

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
     * @return mixed
     */
    public function getFormAction()
    {
        return $this->formAction;
    }

    /**
     * @param $formAction
     *
     * @return $this
     */
    public function setFormAction($formAction): self
    {
        $this->formAction = $formAction;

        return $this;
    }

    /**
     * @return array
     */
    public function getFormAttributes(): array
    {
        return array_replace_recursive(
            [
                'id' => $this->getFormId(),
                'class' => $this->getFormClass(),
            ],
            $this->getFormAttributes()
        );
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
    public function getFormClass(): string
    {
        return $this->formClass;
    }

    /**
     * @param string $formClass
     *
     * @return $this
     */
    public function setFormClass(string $formClass): self
    {
        $this->formClass = $formClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->formId;
    }

    /**
     * @param string $formId
     *
     * @return $this
     */
    public function setFormId(string $formId): self
    {
        $this->formId = $formId;

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
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param string $handle
     *
     * @return $this
     */
    public function setHandle(string $handle): self
    {
        $this->handle = $handle;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     *
     * @return $this
     */
    public function setRedirectUrl(string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
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
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
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

        $actionRoute = $this->getActionRoute();
        $handle = $this->getHandle();
        $rules = $this->getRules();

        if ($rules) {
            $pieces[] = Html::actionInput('formbuilder/forms/process');
            $pieces[] = Html::hiddenInput(self::ACTION_NAME, $actionRoute);

            if ($handle) {
                $pieces[] = Html::hiddenInput(self::HANDLE_NAME, $handle);
            } else {
                $encodedRules = Plugin::getInstance()->getForms()->encodeRules($rules);
                $pieces[] = Html::hiddenInput(self::RULES_NAME, $encodedRules);
            }
        } elseif ($actionRoute) {
            $pieces[] = Html::actionInput($actionRoute);
        }

        if ($redirectUrl = $this->getRedirectUrl()) {
            $pieces[] = Html::redirectInput($redirectUrl);
        }

        $pieces[] = $this->renderComponents();

        $pieces[] = Html::endForm();

        $content = implode(PHP_EOL, $pieces);
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }
}
