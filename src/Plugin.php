<?php

namespace craftplugins\formbuilder;

use craft\base\Plugin as BasePlugin;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craftplugins\formbuilder\controllers\FormController;
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
        'form' => FormController::class,
    ];

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
