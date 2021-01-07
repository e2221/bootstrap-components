<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


use e2221\BootstrapComponents\Tabs\Tabs;

class TabContentItemTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='tab-pane';
    protected string $class='fade';
    private Tab $navItem;

    public function __construct(Tabs $tabs, Tab $navItem)
    {
        parent::__construct($tabs);
        $this->navItem = $navItem;
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addDataAttribute('tab-id', $this->navItem->getId())
            ->addHtmlAttribute('role', 'tabpanel')
            ->addDataAttribute('unique-id', $this->tabs->getUniqueId());
        if($this->navItem->isActive() === true)
            $this->addClass('show active');
    }
}