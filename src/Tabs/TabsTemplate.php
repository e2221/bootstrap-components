<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs;


use e2221\BootstrapComponents\Tabs\Components\HorizontalContentColTemplate;
use e2221\BootstrapComponents\Tabs\Components\HorizontalHeaderColTemplate;
use e2221\BootstrapComponents\Tabs\Components\HorizontalRowTemplate;
use e2221\BootstrapComponents\Tabs\Components\Tab;
use e2221\BootstrapComponents\Tabs\Components\NavTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabContentTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabHeaderTemplate;
use Nette\Bridges\ApplicationLatte\Template;

class TabsTemplate extends Template
{
    /** @var Tab[] */
    public array $tabs;

    /** @var string[] */
    public array $templates;

    public NavTemplate $navTemplate;
    public TabContentTemplate $tabContentTemplate;
    public TabHeaderTemplate $tabHeaderTemplate;
    public HorizontalRowTemplate $horizontalRowTemplate;
    public HorizontalHeaderColTemplate $horizontalHeaderColTemplate;
    public HorizontalContentColTemplate $horizontalContentColTemplate;
    public bool $lazyMode;
    public bool $reloadOnChangeTab;
    public ?string $activeTab;
    public string $style;
}