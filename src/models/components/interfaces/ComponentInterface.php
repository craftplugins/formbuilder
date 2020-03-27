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
     * @return \craftplugins\formbuilder\models\components\interfaces\ParentInterface
     */
    public function getParent(): ParentInterface;

    /**
     * @return \Twig\Markup
     */
    public function render(): Markup;
}
