<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs;


use e2221\BootstrapComponents\Tabs\Components\HorizontalContentColTemplate;
use e2221\BootstrapComponents\Tabs\Components\HorizontalHeaderColTemplate;
use e2221\BootstrapComponents\Tabs\Components\HorizontalRowTemplate;
use e2221\BootstrapComponents\Tabs\Components\NavItem;
use e2221\BootstrapComponents\Tabs\Components\NavTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabContentTemplate;
use e2221\BootstrapComponents\Tabs\Components\TabHeaderTemplate;
use e2221\BootstrapComponents\Tabs\Exceptions\TabsException;
use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
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
    protected HorizontalContentColTemplate $horizontalContentColTemplate;
    protected HorizontalHeaderColTemplate $horizontalHeaderColTemplate;
    protected HorizontalRowTemplate $horizontalRowTemplate;

    /** @var NavItem[] */
    protected array $tabs=[];

    /** @var bool Lazy mode [true = render only content of active tab, false = render all content] */
    protected bool $lazyMode=false;

    /** @var bool Reload on change tab [true = on each table change will be reprinted content, false = content will be cached (html)] */
    protected bool $reloadOnChangeTab=false;

    /** @var string|null @persistent */
    public ?string $activeTab=null;

    /** @var string[] templates with blocks */
    protected array $templates=[];

    /** @var string Style [tab, pill] */
    protected string $style='tab';

    /** @var string Layout [vertical, horizontal] */
    protected string $layout='vertical';

    public function __construct()
    {
        $this->navTemplate = new NavTemplate($this);
        $this->tabContentTemplate = new TabContentTemplate($this);
        $this->tabHeaderTemplate = new TabHeaderTemplate($this);
        $this->horizontalContentColTemplate = new HorizontalContentColTemplate($this);
        $this->horizontalHeaderColTemplate = new HorizontalHeaderColTemplate($this);
        $this->horizontalRowTemplate = new HorizontalRowTemplate($this);
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
     * @throws TabsException
     */
    public function handleTab(string $tabId): void
    {
        $this
            ->setActiveTab($tabId)
            ->getActiveTab()
            ->setPrintContent(true);

        $this->reloadHeader();
        if($this->lazyMode === true)
        {
            $this->reloadSingleContent($tabId);
        }else{
            $this->reloadContent();
        }
    }

    /**
     * Load state
     * @param array $params
     * @throws BadRequestException
     */
    public function loadState(array $params): void
    {
        parent::loadState($params);

        //if lazy mode - stop printing content of non-active container contents
        if($this->lazyMode === true)
        {
            $activeTab = $this->getActiveTabId();
            foreach($this->tabs as $tabId => $tab)
            {
                $tab->setPrintContent($activeTab == $tabId);
            }
        }
    }

    /**
     * Render all
     */
    public function render(): void
    {
        $this->defineTemplateVariables();
        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Render header
     */
    public function renderHeader(): void
    {
        $this->defineTemplateVariables();
        $this->template->setFile(__DIR__ . '/templates/header.latte');
        $this->template->render();
    }

    /**
     * Render content
     */
    public function renderContent(): void
    {
        $this->defineTemplateVariables();
        $this->template->setFile(__DIR__ . '/templates/content.latte');
        $this->template->render();
    }

    private function defineTemplateVariables(): void
    {
        $this->template->navTemplate = $this->navTemplate;
        $this->template->tabContentTemplate = $this->tabContentTemplate;
        $this->template->tabHeaderTemplate = $this->tabHeaderTemplate;
        $this->template->horizontalRowTemplate = $this->horizontalRowTemplate;
        $this->template->horizontalHeaderColTemplate = $this->horizontalHeaderColTemplate;
        $this->template->horizontalContentColTemplate = $this->horizontalContentColTemplate;
        $this->template->tabs = $this->tabs;
        $this->template->lazyMode = $this->lazyMode;
        $this->template->reloadOnChangeTab = $this->reloadOnChangeTab;
        $this->template->activeTab = $this->getActiveTabId();
        $this->template->templates = $this->templates;
        $this->template->style = $this->style;
    }

    /**
     * Set style tabs [default]
     * @return Tabs
     */
    public function setStyleTabs(): self
    {
        $this->style = 'tab';
        return $this;
    }

    /**
     * Set style pills
     * @return Tabs
     */
    public function setStylePills(): self
    {
        $this->style = 'pill';
        return $this;
    }

    /**
     * Get tabs style [tab, pill]
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * Set vertical layout (default)
     * @return Tabs
     */
    public function setLayoutVertical(): self
    {
        $this->layout = 'vertical';
        return $this;
    }

    /**
     * Set horizontal layout
     * @return Tabs
     */
    public function setLayoutHorizontal(): self
    {
        $this->layout = 'horizontal';
        return $this;
    }

    /**
     * Get layout
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * Add template with blocks
     * @param string $templatePath
     * @return Tabs
     */
    public function addTemplate(string $templatePath): self
    {
        $this->templates[] = $templatePath;
        return $this;
    }

    /**
     * Reload
     * @param null|string|array $snippets [null = reload all, string = reload single snippet, array = reload snippets in array]
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
     * @param string $tabId
     * @throws AbortException
     */
    public function reloadSingleContent(string $tabId): void
    {
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
     * Get horizontal content col template
     * @return HorizontalContentColTemplate
     */
    public function getHorizontalContentColTemplate(): HorizontalContentColTemplate
    {
        return $this->horizontalContentColTemplate;
    }

    /**
     * @return HorizontalHeaderColTemplate
     */
    public function getHorizontalHeaderColTemplate(): HorizontalHeaderColTemplate
    {
        return $this->horizontalHeaderColTemplate;
    }

    /**
     * @return HorizontalRowTemplate
     */
    public function getHorizontalRowTemplate(): HorizontalRowTemplate
    {
        return $this->horizontalRowTemplate;
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
     * @return Tabs
     * @throws TabsException
     */
    public function setActiveTab(?string $activeTabId): self
    {
        if(!isset($this->tabs[$activeTabId]))
            throw new TabsException(sprintf('Tab [%s] does not exist.', $activeTabId));
        $this->activeTab = $activeTabId;
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

    /**
     * Set lazy mode [true = render only content of active tab, false = render all]
     * @param bool $lazyMode
     * @return Tabs
     */
    public function setLazyMode(bool $lazyMode=true): self
    {
        $this->lazyMode = $lazyMode;
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
}