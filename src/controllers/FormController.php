<?php

namespace craftplugins\formbuilder\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Response;
use craftplugins\formbuilder\Plugin;
use yii\base\DynamicModel;

/**
 * Class FormController
 *
 * @package craftplugins\formbuilder\controllers
 */
class FormController extends Controller
{
    /**
     * @var bool
     */
    protected $allowAnonymous = true;

    /**
     * @return \craft\web\Response|null
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionProcess(): ?Response
    {
        $request = Craft::$app->getRequest();
        $action = $request->getRequiredBodyParam('formBuilerAction');
        $config = $request->getRequiredBodyParam('formBuilerConfig');

        $rules = Plugin::getInstance()->getForms()->decodeRules($config);

        $model = DynamicModel::validateData($request->getBodyParams(), $rules);

        if ($model->hasErrors()) {
            Craft::$app->getUrlManager()->setRouteParams([
                'formBuilderErrors' => $model->getErrors(),
            ]);

            return null;
        }

        /** @var \craft\web\Response $response */
        $response = Craft::$app->runAction($action);

        return $response;
    }
}
