<?php

namespace craftplugins\formbuilder;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\web\twig\variables\CraftVariable;
use craftplugins\formbuilder\controllers\FormsController;
use craftplugins\formbuilder\models\Config;
use craftplugins\formbuilder\services\Forms;
use craftplugins\formbuilder\services\View;
use craftplugins\formbuilder\variables\FormBuilderVariable;
use yii\base\Event;

/**
 * Class Plugin
 *
 * @package craftplugins\formbuilder
 * @property \craftplugins\formbuilder\services\Forms $forms
 * @property \craftplugins\formbuilder\services\View  $view
 */
class Plugin extends BasePlugin
{
    /**
     * @var array
     */
    public $controllerMap = [
        'forms' => FormsController::class,
    ];

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
            'view' => View::class,
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
     * @return \craftplugins\formbuilder\services\View
     * @throws \yii\base\InvalidConfigException
     */
    public function getView(): View
    {
        /** @var View $service */
        $service = $this->get('view');

        return $service;
    }
}
