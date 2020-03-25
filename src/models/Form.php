<?php

namespace craftplugins\formbuilder\models;

use Craft;
use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\helpers\Html;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\components\traits\ParentTrait;
use Twig\Markup;
use yii\base\BaseObject;

/**
 * Class Form
 *
 * @package craftplugins\formbuilder\models\components
 */
class Form extends BaseObject implements ParentInterface
{
    use ParentTrait;

    public const ACTION_NAME = 'formBuilderAction';

    public const HANDLE_NAME = 'formBuilderHandle';

    public const RULES_NAME = 'formBuilderRules';

    public const VALUES_KEY = 'formBuilderValues';

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
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var array
     */
    protected $rowAttributes = ['class' => 'form-row'];

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
            $this->setErrors($dynamicModel->getErrors());
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

        $content = implode(PHP_EOL, $pieces);
        $charset = Craft::$app->getView()->getTwig()->getCharset();

        return new Markup($content, $charset);
    }
}
