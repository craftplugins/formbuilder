<?php

namespace craftplugins\formbuilder\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Response;
use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\models\Values;
use craftplugins\formbuilder\Plugin;

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
        $action = $request->getRequiredBodyParam(Form::ACTION_NAME);
        $config = $request->getRequiredBodyParam(Form::RULES_NAME);

        $rules = Plugin::getInstance()->getForms()->decodeRules($config);

        $model = Values::validateData($request->getBodyParams(), $rules);

        if ($model->hasErrors()) {
            Craft::$app->getUrlManager()->setRouteParams([
                Form::VALUES_ROUTE_PARAMS_KEY => $model,
            ]);

            return null;
        }

        /** @var \craft\web\Response $response */
        $response = Craft::$app->runAction($action);

        return $response;
    }
}
