<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs;


use e2221\BootstrapComponents\Tabs\Components\NavItem;
use e2221\BootstrapComponents\Tabs\Components\NavTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabContentTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabHeaderTemplate;
use Nette\Bridges\ApplicationLatte\Template;

class TabsTemplate extends Template
{
    /** @var NavItem[] */
    public array $tabs;

    public NavTemplate $navTemplate;
    public TabContentTemplate $tabContentTemplate;
    public TabHeaderTemplate $tabHeaderTemplate;
    public bool $lazyMode;
}