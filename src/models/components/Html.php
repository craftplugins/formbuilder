<?php

namespace craftplugins\formbuilder\models\components;

use craftplugins\formbuilder\Plugin;
use Twig\Markup;

/**
 * Class Html
 *
 * @package craftplugins\formbuilder\models\components
 */
class Html extends AbstractComponent
{
    /**
     * @var string|null
     */
    protected $content;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return \Twig\Markup
     * @throws \yii\base\InvalidConfigException
     */
    public function render(): Markup
    {
        return Plugin::getInstance()->getView()->createMarkup($this->getContent());
    }
}
