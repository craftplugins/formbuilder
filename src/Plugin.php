<?php

namespace craftplugins\formbuilder;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\web\twig\variables\CraftVariable;
use craftplugins\formbuilder\controllers\FormsController;
use craftplugins\formbuilder\models\Config;
use craftplugins\formbuilder\services\FormsService;
use craftplugins\formbuilder\variables\FormsBuilderVariable;
use yii\base\Event;

/**
 * Class Plugin
 *
 * @package craftplugins\formbuilder
 * @property \craftplugins\formbuilder\services\FormsService $forms
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
            'forms' => FormsService::class,
        ]);

        // Register variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            static function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('formsBuilder', FormsBuilderVariable::class);
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
     * @return \craftplugins\formbuilder\services\FormsService
     * @throws \yii\base\InvalidConfigException
     */
    public function getForms(): FormsService
    {
        /** @var FormsService $service */
        $service = $this->get('forms');

        return $service;
    }
}
