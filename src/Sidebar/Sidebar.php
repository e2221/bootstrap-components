<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar;

use e2221\BootstrapComponents\Sidebar\Components\Item;
use e2221\BootstrapComponents\Sidebar\Components\ItemsList;
use e2221\BootstrapComponents\Sidebar\Document\NavTemplate;
use e2221\BootstrapComponents\Sidebar\Document\UlWrapperTemplate;
use e2221\BootstrapComponents\Sidebar\Exceptions\SidebarException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

class Sidebar extends Control
{
    const
        SNIPPET_SIDEBAR_AREA = 'sidebarArea',
        SNIPPET_SIDEBAR = 'sidebar';

    /** @var ItemsList[] Lists of items */
    protected array $lists=[];

    protected NavTemplate $navTemplate;
    protected UlWrapperTemplate $ulWrapperTemplate;

    public function __construct()
    {
        $this->navTemplate = new NavTemplate($this);
        $this->ulWrapperTemplate = new UlWrapperTemplate($this);
    }

    /**
     * Add new list
     * @param string $name
     * @param string|null $title
     * @return ItemsList
     */
    public function addList(string $name, ?string $title=null): ItemsList
    {
         return $this->lists[$name] = new ItemsList($this, $name, $title);
    }

    /**
     * @param string $list
     * @param string $item
     * @throws SidebarException
     */
    public function handleLink(string $list, string $item): void
    {
        $navItem = $this->getItem($list, $item);
        $linkCallback = $navItem->getOnClickCallback();
        if(is_callable($linkCallback))
            $linkCallback($this, $navItem, $navItem->backToList());
        $this->reload();
    }

    public function render(): void
    {
        $this->template->lists = $this->getLists();
        $this->template->sidebarNavTemplate = $this->navTemplate;
        $this->template->ulWrapperTemplate = $this->ulWrapperTemplate;
        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Get all lists
     * @return ItemsList[]
     */
    public function getLists(): array
    {
        return $this->lists;
    }

    /**
     * Get single list
     * @param string $name
     * @return ItemsList
     * @throws SidebarException
     */
    public function getList(string $name): ItemsList
    {
        if(isset($this->lists[$name]) === false)
            throw new SidebarException(sprintf('List [%s] does not exist', $name));
        return $this->lists[$name];
    }

    /**
     * Get item
     * @param string $listName
     * @param string $itemName
     * @return Item
     * @throws SidebarException
     */
    public function getItem(string $listName, string $itemName): Item
    {
        return $this->getList($listName)->getItem($itemName);
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
     * Get ul wrapper template
     * @return UlWrapperTemplate
     */
    public function getUlWrapperTemplate(): UlWrapperTemplate
    {
        return $this->ulWrapperTemplate;
    }

    /**
     * Reload sidebar
     * @param bool $onlyAjaxRequest
     */
    public function reload(bool $onlyAjaxRequest=true): void
    {
        if($onlyAjaxRequest === true && $this->getPresenter()->isAjax() === false)
            return;
        $this->redrawControl(self::SNIPPET_SIDEBAR_AREA);
        $this->redrawControl(self::SNIPPET_SIDEBAR);
    }

    /**
     * Reload sidebar item
     * @param string $listName
     * @param string $itemName
     */
    public function reloadItem(string $listName, string $itemName): void
    {
        if($this->getPresenter()->isAjax() === true)
        {
            $this->redrawControl(self::SNIPPET_SIDEBAR_AREA);
            $this->redrawControl(sprintf('sidebar-%s-%s', $listName, $itemName));
        }
    }
}


class SidebarTemplate extends Template
{
    /** @var ItemsList[] */
    public array $lists;

    public NavTemplate $sidebarNavTemplate;
    public UlWrapperTemplate $ulWrapperTemplate;

}