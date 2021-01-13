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

    /** @var Item[] List of all items  */
    protected array $items=[];

    /** @var null|callable on reload single item: function(Item $item, ItemsList $itemsList, Sidebar $sidebar): void */
    protected $onReloadItemCallback=null;

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
     */
    public function handleLink(string $list, string $item): void
    {
        try {
            $navItem = $this->getItem($list, $item);
            $linkCallback = $navItem->getOnClickCallback();
            if(is_callable($linkCallback))
                $linkCallback($this, $navItem, $navItem->backToList());
        } catch (SidebarException $e) {
        }
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
     * Get item - all items must have unique name!
     * @param string $itemName
     * @return Item
     * @throws SidebarException
     */
    public function getItem_unique(string $itemName): Item
    {
        if(isset($this->items[$itemName]) === false)
            throw new SidebarException(sprintf('Item [%s] does not exist', $itemName));
        return $this->items[$itemName];
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
     * @param string|Item $item
     * @param string|null $listName
     * @throws SidebarException
     */
    public function reloadItem($item, ?string $listName=null): void
    {
        if($this->getPresenter()->isAjax() === false)
            return;
        if(is_callable($fn = $this->onReloadItemCallback))
        {
            if(is_string($item))
                $item = is_null($listName) ? $this->getItem_unique($item) : $this->getItem($listName, $item);
            $fn($item, $item->getList(), $this);
        }
        $this->redrawControl(self::SNIPPET_SIDEBAR_AREA);
        $this->redrawControl(sprintf('sidebar-%s-%s', $listName, $item));
    }


    /**
     * On item add - add item to list of items
     * @param Item $item
     * @internal
     */
    public function onItemAdd(Item $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * Get all items
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set item active (be sure that all items in all lists has unique name!)
     * @param string $itemName
     * @param string|null $listName
     * @return Sidebar
     * @throws SidebarException
     */
    public function setItemActive(string $itemName, ?string $listName=null): self
    {
        if(is_string($listName) === true)
        {
            $item = $this->getItem($listName, $itemName);
        }else{
            $item = $this->getItem_unique($itemName);
        }
        $item->setActive();
        return $this;
    }

    /**
     * Set on reload item callback
     * @param callable|null $onReloadItemCallback function(Item $item, ItemsList $itemsList, Sidebar $sidebar): void
     * @return Sidebar
     */
    public function setOnReloadItemCallback(?callable $onReloadItemCallback): self
    {
        $this->onReloadItemCallback = $onReloadItemCallback;
        return $this;
    }
}


class SidebarTemplate extends Template
{
    /** @var ItemsList[] */
    public array $lists;

    public NavTemplate $sidebarNavTemplate;
    public UlWrapperTemplate $ulWrapperTemplate;

}