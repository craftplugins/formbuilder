<?php

namespace craftplugins\formbuilder\controllers;

use Craft;
use craft\web\Controller;
use craft\web\Response;
use craft\web\UploadedFile;
use craftplugins\formbuilder\helpers\ArrayHelper;
use craftplugins\formbuilder\models\DynamicModel;
use craftplugins\formbuilder\models\Form;
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
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();
        $action = $request->getRequiredBodyParam(Form::ACTION_NAME);
        $handle = $request->getRequiredBodyParam(Form::HANDLE_NAME);

        $form = Plugin::getInstance()->getForms()->getFormByHandle($handle);
        $rules = $form->getRules();
        $values = $request->getBodyParams();

        foreach ($rules as $rule) {
            $attribute = $rule[0];

            if (ArrayHelper::getValue($values, $attribute) !== null) {
                continue;
            }

            if ($uploadedFile = UploadedFile::getInstanceByName($attribute)) {
                ArrayHelper::setValue($values, $attribute, $uploadedFile);
            }
        }

        $model = DynamicModel::validateData($values, $rules);

        Craft::$app->getUrlManager()->setRouteParams([
            Form::VALUES_KEY => $model,
        ]);

        if ($model->hasErrors() && !$form->isActionRunWithErrors()) {
            return null;
        }

        /** @var \craft\web\Response $response */
        $response = Craft::$app->runAction($action);

        return $response;
    }
}
