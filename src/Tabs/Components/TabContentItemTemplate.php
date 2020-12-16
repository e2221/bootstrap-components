<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


class TabContentItemTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='tab-pane';
    protected string $class='fade';

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->addHtmlAttribute('role', 'tabpanel');
    }

}