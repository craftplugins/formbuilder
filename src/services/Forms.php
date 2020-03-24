<?php

namespace craftplugins\formbuilder\services;

use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;
use craftplugins\formbuilder\models\components\Form;
use craftplugins\formbuilder\Plugin;
use yii\base\Exception;

/**
 * Class FormsService
 *
 * @package craftplugins\formbuilder\services
 * @property array|\craftplugins\formbuilder\models\components\Form[] $forms
 */
class Forms extends Component
{
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
     * @return Form[]
     */
    public function getForms():array
    {
        $forms = Plugin::getInstance()->getConfig()->forms;

        foreach ($forms as &$form) {
            if ($form instanceof Form) {
                continue;
            }

            $form = new Form($form);
        }

        return $forms;
    }

    /**
     * @param string $handle
     *
     * @return \craftplugins\formbuilder\models\components\Form
     * @throws \yii\base\Exception
     */
    public function getFormByHandle(string $handle): Form
    {
        foreach ($this->getForms() as $form) {
            if ($form->getHandle() === $handle) {
                return $form;
            }
        }

        throw new Exception("No form found with handle: {$handle}");
    }
}
