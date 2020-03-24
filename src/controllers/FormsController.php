<?php

namespace craftplugins\formbuilder\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Response;
use craftplugins\formbuilder\models\components\Form;
use craftplugins\formbuilder\Plugin;
use yii\base\DynamicModel;

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
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();
        $action = $request->getRequiredBodyParam(Form::ACTION_NAME);
        $handle = $request->getRequiredBodyParam(Form::HANDLE_NAME);

        if ($handle) {
            // If a handle is set we’ll use the configured rules
            $form = Plugin::getInstance()->getForms()->getFormByHandle($handle);
            $rules = $form->getRules();
        } else {
            // If no handle is set we’ll try and load any encoded rules
            $encodedRules = $request->getRequiredBodyParam(Form::RULES_NAME);
            $rules = Plugin::getInstance()->getForms()->decodeRules($encodedRules);
        }

        // Validate the posted data with our rules
        // We’re using Yii’s DynamicModel here to conduct ad hoc validation
        $model = DynamicModel::validateData($request->getBodyParams(), $rules);

        if ($model->hasErrors()) {
            Craft::$app->getUrlManager()->setRouteParams([
                Form::VALUES_KEY => $model,
            ]);

            return null;
        }

        /** @var \craft\web\Response $response */
        $response = Craft::$app->runAction($action);

        return $response;
    }
}
