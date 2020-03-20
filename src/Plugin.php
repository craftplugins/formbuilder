<?php

namespace craftplugins\formbuilder;

use craft\base\Plugin as BasePlugin;
use craftplugins\formbuilder\services\FormsService;

/**
 * Class Plugin
 *
 * @package craftplugins\formbuilder
 * @property \craftplugins\formbuilder\services\FormsService $forms
 */
class Plugin extends BasePlugin
{
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
