<?php

namespace craftplugins\formbuilder;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\events\RegisterComponentTypesEvent;
use craft\web\twig\variables\CraftVariable;
use craftplugins\formbuilder\controllers\FormsController;
use craftplugins\formbuilder\models\components\ButtonField;
use craftplugins\formbuilder\models\components\InputField;
use craftplugins\formbuilder\models\components\Row;
use craftplugins\formbuilder\models\components\SelectField;
use craftplugins\formbuilder\models\components\TextareaField;
use craftplugins\formbuilder\models\Config;
use craftplugins\formbuilder\services\Forms;
use craftplugins\formbuilder\variables\FormBuilderVariable;
use yii\base\Event;

/**
 * Class Plugin
 *
 * @package craftplugins\formbuilder
 * @property \craftplugins\formbuilder\services\Forms $forms
 */
class Plugin extends BasePlugin
{
    public const EVENT_REGISTER_COMPONENT_TYPES = 'registerFormComponentTypes';

    /**
     * @var array
     */
    public $controllerMap = [
        'forms' => FormsController::class,
    ];

    /**
     * @var array
     */
    protected $componentTypes;

    /**
     * @var array
     */
    protected $config;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        $this->setComponents([
            'forms' => Forms::class,
        ]);

        // Register variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            static function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('formBuilder', FormBuilderVariable::class);
            }
        );

        // Register our own form component types
        $this->registerComponentTypes();
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        /** @var self $instance */
        $instance = parent::getInstance();

        return $instance;
    }

    /**
     * @return array
     */
    public function getComponentTypes(): array
    {
        return $this->componentTypes;
    }

    /**
     * @return \craftplugins\formbuilder\models\Config
     */
    public function getConfig(): Config
    {
        if ($this->config === null) {
            $this->config = new Config(
                Craft::$app->getConfig()->getConfigFromFile('formbuilder')
            );
        }

        return $this->config;
    }

    /**
     * @return \craftplugins\formbuilder\services\Forms
     * @throws \yii\base\InvalidConfigException
     */
    public function getForms(): Forms
    {
        /** @var Forms $service */
        $service = $this->get('forms');

        return $service;
    }

    /**
     * @return void
     */
    protected function registerComponentTypes(): void
    {
        $event = new RegisterComponentTypesEvent();

        // Set our default types
        $event->types = [
            'button' => ButtonField::class,
            'checkbox' => InputField::class,
            'color' => InputField::class,
            'date' => InputField::class,
            'datetime-local' => InputField::class,
            'email' => InputField::class,
            'file' => InputField::class,
            'hidden' => InputField::class,
            'image' => InputField::class,
            'input' => InputField::class,
            'month' => InputField::class,
            'number' => InputField::class,
            'password' => InputField::class,
            'radio' => InputField::class,
            'range' => InputField::class,
            'reset' => InputField::class,
            'row' => Row::class,
            'search' => InputField::class,
            'select' => SelectField::class,
            'submit' => InputField::class,
            'tel' => InputField::class,
            'text' => InputField::class,
            'textarea' => TextareaField::class,
            'time' => InputField::class,
            'url' => InputField::class,
            'week' => InputField::class,
        ];

        $this->trigger(self::EVENT_REGISTER_COMPONENT_TYPES, $event);

        $this->componentTypes = $event->types;
    }
}
