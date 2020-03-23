<?php

namespace craftplugins\formbuilder\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Response;
use craftplugins\formbuilder\models\Form;
use craftplugins\formbuilder\models\Values;
use craftplugins\formbuilder\Plugin;

/**
 * Class FormsController
 *
 * @package craftplugins\formbuilder\controllers
 */
class FormsController extends Controller
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
        $handle = $request->getRequiredBodyParam(Form::HANDLE_NAME);
        $encodedRules = $request->getRequiredBodyParam(Form::RULES_NAME);

        if ($handle) {
            $form = Plugin::getInstance()->getForms()->getFormByHandle($handle);
            $rules = $form->rules;
        } else {
            $rules = Plugin::getInstance()->getForms()->decodeRules($encodedRules);
        }

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
