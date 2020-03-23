<?php

namespace craftplugins\formbuilder\services;

use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\Plugin;
use yii\base\Exception;

/**
 * Class FormsService
 *
 * @package craftplugins\formbuilder\services
 */
class FormsService extends Component
{
    /**
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\Form
     */
    public function createForm(array $config): Form
    {
        return new Form(null, $config);
    }

    /**
     * @param array $rules
     *
     * @return string
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function encodeRules(array $rules): string
    {
        return StringHelper::base64UrlEncode(
            Craft::$app->getSecurity()->encryptByKey(
                serialize($rules)
            )
        );
    }

    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\Form
     * @throws \yii\base\Exception
     */
    public function getFormByHandle(string $handle): Form
    {
        $forms = Plugin::getInstance()->getConfig()->forms;

        foreach ($forms as $config) {
            if ($config instanceof Form) {
                $form = $config;
            } else {
                $form = $this->createForm((array) $config);
            }

            if ($form->handle === $handle) {
                return $form;
            }
        }

        throw new Exception("No form found with handle: {$handle}");
    }

    /**
     * @param string $rules
     *
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function decodeRules(string $rules): array
    {
        return unserialize(
            Craft::$app->getSecurity()->decryptByKey(
                StringHelper::base64UrlDecode($rules)
            ),
            [
                'allowed_classes' => false,
            ]
        );
    }
}
