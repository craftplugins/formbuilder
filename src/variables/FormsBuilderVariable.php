<?php

namespace craftplugins\formbuilder\variables;

use craftplugins\formbuilder\models\Form;

/**
 * Class FormsBuilderVariable
 *
 * @package craftplugins\formbuilder\variables
 */
class FormsBuilderVariable
{
    /**
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\Form
     */
    public function getForm(array $config): Form
    {
        return new Form($config);
    }
}
