<?php

namespace craftplugins\formbuilder\models\components\interfaces;

use craftplugins\formbuilder\models\Form;
use Twig\Markup;

/**
 * Interface ComponentInterface
 *
 * @package craftplugins\formbuilder\models\components
 */
interface ComponentInterface
{
    /**
     * @return \craftplugins\formbuilder\models\Form
     */
    public function getForm(): Form;

    /**
     * @return \Twig\Markup
     */
    public function render(): Markup;

    /**
     * @param \craftplugins\formbuilder\models\Form $form
     *
     * @return $this
     */
    public function setForm(Form $form): self;
}
