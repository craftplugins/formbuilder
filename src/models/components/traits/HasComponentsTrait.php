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
     * @return \craftplugins\formbuilder\models\components\traits\HasComponentsTrait
     */
    public function addComponent($component): HasComponentsTrait
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
     * @param mixed ...$components
     *
     * @return $this
     */
    public function addComponents(...$components): self
    {
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
     * @return $this
     */
    public function setComponents(array $fields): self
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
        $componentType = $config['type'] ?? 'input';

        if (!ArrayHelper::isAssociative($config)) {
            // Assume we’re building a row for non-associative arrays
            return Row::create($config);
        }

        $componentTypes = Plugin::getInstance()->getComponentTypes();

        if (empty($componentTypes[$componentType])) {
            throw new InvalidArgumentException("Missing component type: {$componentType}");
        }

        $component = new $componentType($config);

        if ($component instanceof ComponentInterface) {
            return $component;
        }

        throw new InvalidArgumentException("Invalid component type: {$componentType}");
    }

    /**
     * @return \Twig\Markup
     */
    public function renderComponents(): Markup
    {
        $pieces = [];

        foreach ($this->getComponents() as $component) {
            $pieces[] = $component->render();
        }

        return new Markup(
            implode(PHP_EOL, $pieces),
            Craft::$app->getView()->getTwig()->getCharset()
        );
    }
}
