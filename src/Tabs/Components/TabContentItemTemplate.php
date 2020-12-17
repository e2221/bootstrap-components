<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


use e2221\BootstrapComponents\Tabs\Tabs;

class TabContentItemTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='tab-pane';
    protected string $class='fade';
    private Tabs $tabs;
    private NavItem $navItem;

    public function __construct(Tabs $tabs, NavItem $navItem)
    {
        parent::__construct();
        $this->tabs = $tabs;
        $this->navItem = $navItem;
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
          //  ->addHtmlAttribute('id', sprintf('%s-tab-%s', $this->tabs->getUniqueId(), $this->navItem->getId())),
              ->addDataAttribute('tab-id', $this->navItem->getId())
            ->addHtmlAttribute('role', 'tabpanel');

        if($this->navItem->isActive() === true)
        {
            $this->addClass('show active');
        }
    }

}