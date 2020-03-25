<?php

namespace craftplugins\formbuilder\models\components\traits;

use Craft;
use craft\helpers\ArrayHelper;
use craftplugins\formbuilder\models\components\ComponentInterface;
use craftplugins\formbuilder\models\components\Row;
use craftplugins\formbuilder\Plugin;
use Twig\Markup;
use yii\base\InvalidArgumentException;

/**
 * Trait HasComponentsTrait
 *
 * @package craftplugins\formbuilder\models\components\traits
 */
trait HasComponentsTrait
{
    /**
     * @var \craftplugins\formbuilder\models\components\AbstractComponent[]
     */
    protected $components = [];

    /**
     * @param ComponentInterface|array $component
     *
     * @return \craftplugins\formbuilder\models\components\ComponentInterface|\craftplugins\formbuilder\models\components\traits\HasComponentsTrait
     */
    public function addComponent($component): ComponentInterface
    {
        if (is_array($component)) {
            $component = $this->createComponent($component);
        }

        if ($component instanceof ComponentInterface) {
            $this->components[] = $component;

            return $this;
        }

        throw new InvalidArgumentException('Invalid component.');
    }

    /**
     * @param                                                                $first
     * @param \craftplugins\formbuilder\models\components\ComponentInterface ...$components
     *
     * @return \craftplugins\formbuilder\models\components\ComponentInterface|\craftplugins\formbuilder\models\components\traits\HasComponentsTrait
     */
    public function addComponents($first, ComponentInterface ...$components): ComponentInterface
    {
        if (!is_array($first)) {
            $first = [$first];
        }

        foreach ($first as $component) {
            $this->addComponent($component);
        }

        foreach ($components as $component) {
            $this->addComponent($component);
        }

        return $this;
    }

    /**
     * @return \craftplugins\formbuilder\models\components\AbstractComponent[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param array $fields
     *
     * @return \craftplugins\formbuilder\models\components\ComponentInterface|\craftplugins\formbuilder\models\components\traits\HasComponentsTrait
     */
    public function setComponents(array $fields): ComponentInterface
    {
        $this->components = [];
        $this->addComponents($fields);

        return $this;
    }

    /**
     * @param array $config
     *
     * @return \craftplugins\formbuilder\models\components\ComponentInterface
     */
    protected function createComponent(array $config): ComponentInterface
    {
        $componentType = ArrayHelper::getValue($config, 'type', 'input');

        if (ArrayHelper::isAssociative($config) === false) {
            // Assume we’re building a row for non-associative arrays
            return Row::create($config);
        }

        $componentTypes = Plugin::getInstance()->getComponentTypes();

        if (empty($componentClass = $componentTypes[$componentType])) {
            throw new InvalidArgumentException("Missing component type: {$componentType}");
        }

        $component = new $componentClass($config);

        if ($component instanceof ComponentInterface) {
            return $component;
        }

        throw new InvalidArgumentException("Invalid component type: {$componentType}");
    }

    /**
     * @return string
     */
    public function getComponentsHtml(): string
    {
        $pieces = [];

        foreach ($this->getComponents() as $component) {
            $pieces[] = $component->render();
        }

        return implode(PHP_EOL, $pieces);
    }
}
