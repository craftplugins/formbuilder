<?php

namespace craftplugins\formbuilder\services;

use Craft;
use craft\base\Component;
use craft\helpers\StringHelper;

/**
 * Class FormsService
 *
 * @package craftplugins\formbuilder\services
 */
class FormsService extends Component
{
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
     * @param string $rules
     *
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function decodeRules(string $rules):array
    {
        return unserialize(
            Craft::$app->getSecurity()->decryptByKey(
                StringHelper::base64UrlDecode($rules)
            ),
            null
        );
    }
}