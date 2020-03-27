<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\interfaces\ComponentInterface;
use craftplugins\formbuilder\models\Form;
use yii\base\BaseObject;

/**
 * Class AbstractComponent
 *
 * @package craftplugins\formbuilder\models\components
 */
abstract class AbstractComponent extends BaseObject implements ComponentInterface
{
    /**
     * @var \craftplugins\formbuilder\models\Form
     */
    protected $form;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->render();
    }

    /**
     * @inheritDoc
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @inheritDoc
     */
    public function setForm(Form $form): ComponentInterface
    {
        $this->form = $form;

        return $this;
    }
}
