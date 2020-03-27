<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\models\components\interfaces\ComponentInterface;
use craftplugins\formbuilder\models\components\interfaces\ParentInterface;
use craftplugins\formbuilder\models\components\traits\ParentTrait;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class BaseFieldGroup
 *
 * @package craftplugins\formbuilder\models\components
 * @property null|array $values
 * @property array      $columnOptions
 * @property null|array $defaultValues
 * @property null|array $errors
 * @property array      $rowOptions
 */
class BaseFieldGroup extends AbstractComponent implements ParentInterface
{
    use ParentTrait;

    /**
     * @param \craftplugins\formbuilder\models\components\interfaces\ComponentInterface[] $components
     * @param array                                                                       $config
     *
     * @return \craftplugins\formbuilder\models\components\AbstractComponent
     */
    public static function create(array $components = [], $config = []): AbstractComponent
    {
        $instance = new static($config);
        $instance->setComponents($components);

        return $instance;
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        $componentPieces = [];

        foreach ($this->getComponents() as $component) {
            $componentPieces[] = $component->render();
        }

        $componentHtml = implode("\n", $componentPieces);

        return Plugin::getInstance()->getView()->createMarkup($componentHtml);
    }
}
