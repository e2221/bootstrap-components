<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


class TabHeaderTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='nav nav-tabs';

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->addHtmlAttribute('role', 'tablist');
    }
}