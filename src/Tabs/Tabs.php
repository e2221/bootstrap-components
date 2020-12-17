<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs;


use e2221\BootstrapComponents\Tabs\Components\NavItem;
use e2221\BootstrapComponents\Tabs\Components\NavTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabContentTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabHeaderTemplate;
use e2221\BootstrapComponents\Tabs\Exceptions\TabsException;
use Nette\Application\AbortException;
use Nette\Application\UI\Control;

class Tabs extends Control
{
    const
        SNIPPET_TABS_AREA = 'tabsArea',
        SNIPPET_HEADER = 'tabsHeader',
        SNIPPET_CONTENT = 'tabsContent',
        SNIPPET_ALL = 'tabs',
        SNIPPET_CONTENT_AREA = 'tabContentArea';

    protected NavTemplate $navTemplate;
    protected TabContentTemplate $tabContentTemplate;
    protected TabHeaderTemplate $tabHeaderTemplate;

    /** @var NavItem[] */
    protected array $tabs=[];

    /** @var bool Lazy mode [true = render only content of active tab, false = render all content] */
    protected bool $lazyMode=false;

    /** @var bool Reload on change tab [true = on each table change will be reprinted content, false = content will be cached (html)] */
    protected bool $reloadOnChangeTab=false;

    /** @var string|null @persistent */
    public ?string $activeTab=null;

    public function __construct()
    {
        $this->navTemplate = new NavTemplate();
        $this->tabContentTemplate = new TabContentTemplate();
        $this->tabHeaderTemplate = new TabHeaderTemplate();
    }

    /**
     * Add tab
     * @param string $id
     * @param string|null $title
     * @return NavItem
     */
    public function addTab(string $id, ?string $title=null)
    {
        $title = $title ?? ucfirst($id);
        return $this->tabs[$id] = new NavItem($this, $id, $title);
    }


    /**
     * Change active table
     * @param string $tabId
     * @throws AbortException
     */
    public function handleTab(string $tabId): void
    {
        $this->activeTab = $tabId;
        $this->reloadHeader();

        if($this->lazyMode === true)
        {
            $this->reloadSingleContent($tabId);
        }else{
            $this->reloadContent();
        }
    }


    public function render(): void
    {
        $this->template->navTemplate = $this->navTemplate;
        $this->template->tabContentTemplate = $this->tabContentTemplate;
        $this->template->tabHeaderTemplate = $this->tabHeaderTemplate;
        $this->template->tabs = $this->tabs;
        $this->template->lazyMode = $this->lazyMode;
        $this->template->reloadOnChangeTab = $this->reloadOnChangeTab;
        $this->template->activeTab = $this->getActiveTabId();

        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }


    /**
     * Reload
     * @param null|string|array $snippets
     * @throws AbortException
     */
    public function reload($snippets=null): void
    {
        if($this->getPresenter()->isAjax())
        {
            $this->redrawControl(self::SNIPPET_TABS_AREA);
            if(is_null($snippets))
            {
                $this->redrawControl(self::SNIPPET_ALL);
            }else if (is_string($snippets))
            {
                $this->redrawControl($snippets);
            }else{
                foreach($snippets as $snippet)
                    $this->redrawControl($snippet);
            }
        }else{
            $this->redirect('this');
        }
    }

    /**
     * Reload header
     * @throws AbortException
     */
    public function reloadHeader(): void
    {
        $this->reload(self::SNIPPET_HEADER);
    }

    /**
     * Reload content
     * @throws AbortException
     */
    public function reloadContent(): void
    {
        $this->reload(self::SNIPPET_CONTENT);
    }

    /**
     * Reload single item content
     * @throws AbortException
     */
    public function reloadSingleContent(string $tabId): void
    {
        //$this->reload(self::SNIPPET_CONTENT_AREA);
        $this->reload('tab-'.$tabId);
    }

    /**
     * Get nav template
     * @return NavTemplate
     */
    public function getNavTemplate(): NavTemplate
    {
        return $this->navTemplate;
    }

    /**
     * Get tab content template
     * @return TabContentTemplate
     */
    public function getTabContentTemplate(): TabContentTemplate
    {
        return $this->tabContentTemplate;
    }

    /**
     * Get tab header template
     * @return TabHeaderTemplate
     */
    public function getTabHeaderTemplate(): TabHeaderTemplate
    {
        return $this->tabHeaderTemplate;
    }

    /**
     * Get tab
     * @param string $id
     * @return NavItem
     * @throws TabsException
     */
    public function getTab(string $id): NavItem
    {
        if(!isset($this->tabs[$id]))
            throw new TabsException(sprintf('Tab [%s] does not exist.', $id));
        return $this->tabs[$id];
    }

    /**
     * Set active tab
     * @param string|null $activeTabId
     * @throws TabsException
     */
    public function setActiveTab(?string $activeTabId): void
    {
        if(!isset($this->tabs[$activeTabId]))
            throw new TabsException(sprintf('Tab [%s] does not exist.', $activeTabId));
        $this->activeTab = $activeTabId;
    }

    /**
     * Set lazy mode [true = render only content of active tab, false = render all]
     * @param bool $lazyMode
     * @return Tabs
     */
    public function setLazyMode(bool $lazyMode=true): self
    {
        $this->lazyMode = $lazyMode;
        $activeTab = $this->getActiveTabId();
        foreach($this->tabs as $tabId => $tab)
        {
            $tab->setPrintContent($activeTab == $tabId);
        }
        return $this;
    }

    /**
     * Set reload on change tab => always on tab change the content will be reloaded
     * @param bool $reloadOnChangeTab
     * @return Tabs
     */
    public function setReloadOnChangeTab(bool $reloadOnChangeTab=true): self
    {
        $this->reloadOnChangeTab = $reloadOnChangeTab;
        return $this;
    }

    /**
     * Get active tab id
     * @return string|null
     */
    public function getActiveTabId(): ?string
    {
        if(count($this->tabs) == 0)
            return null;
        return $this->activeTab ?? array_key_first($this->tabs);
    }

    /**
     * Get active tab
     * @return NavItem|null
     */
    public function getActiveTab(): ?NavItem
    {
        $activeTab = $this->getActiveTabId();
        if(is_null($activeTab))
            return null;
        return $this->tabs[$activeTab];
    }

}