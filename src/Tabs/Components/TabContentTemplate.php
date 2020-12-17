<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


class TabContentTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='tab-content';

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->addDataAttribute('dynamic-mask', 'snippet--tab-\\d+');
    }
}