<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar;

use e2221\BootstrapComponents\Sidebar\Components\Item;
use e2221\BootstrapComponents\Sidebar\Components\ItemsList;
use e2221\BootstrapComponents\Sidebar\Document\NavTemplate;
use e2221\BootstrapComponents\Sidebar\Document\UlWrapperTemplate;
use e2221\BootstrapComponents\Sidebar\Events\ItemAddEvent;
use e2221\BootstrapComponents\Sidebar\Events\ItemEditEvent;
use e2221\BootstrapComponents\Sidebar\Exceptions\SidebarException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Sidebar extends Control implements EventSubscriberInterface
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

    /** @var null|callable add list with item in callback: function(Sidebar $this): void  */
    protected $addListsCallback=null;

    /** @var callable[] function(Sidebar $this):void  */
    protected array $beforeRender=[];

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
     * Signal - item link
     * @param string $list
     * @param string $item
     */
    public function handleLink(string $list, string $item): void
    {
        $this->getLists();
        try{
            $navItem = $this->getItem($list, $item);
            $linkCallback = $navItem->getOnClickCallback();
            if(is_callable($linkCallback))
                $linkCallback($this, $navItem, $navItem->backToList());
        }catch (SidebarException $exception) {
            $this->reload();
        }
    }

    /**
     * Renderer
     */
    public function render(): void
    {
        $lists = $this->getLists();
        foreach($this->beforeRender as $beforeRenderCallback)
            $beforeRenderCallback($this);
        $this->template->lists = $lists;
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
        if(is_callable($fn = $this->addListsCallback))
            $fn($this);
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
        $this->getLists();
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
        $this->getLists();
        if(is_string($item))
            $item = is_null($listName) ? $this->getItem_unique($item) : $this->getItem($listName, $item);
        if(is_callable($fn = $this->onReloadItemCallback))
            $fn($item, $item->getList(), $this);
        $this->redrawControl(self::SNIPPET_SIDEBAR_AREA);
        $this->redrawControl(sprintf('sidebar-%s-%s', $item->getList()->getName(), $item->getName()));
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

    /**
     * Set add lists callback
     * @param callable $addListsCallback function(Sidebar $this): void
     * @return Sidebar
     */
    public function setAddListsCallback(callable $addListsCallback): self
    {
        $this->addListsCallback = $addListsCallback;
        return $this;
    }

    /**
     * Add before render callback
     * @param callable $callback
     * @param bool $clearCallbacks
     */
    public function addBeforeRenderCallback(callable $callback, bool $clearCallbacks=false): void
    {
        if($clearCallbacks === true)
            $this->beforeRender = [];
        $this->beforeRender[] = $callback;
    }

    /**
     * Reload event
     * @internal
     */
    public function reloadEvent(): void
    {
        $this->reload();
    }

    /**
     * Reload item event
     * @param ItemEditEvent $editEvent
     * @throws SidebarException
     * @internal
     */
    public function reloadItemEvent(ItemEditEvent $editEvent): void
    {
        $this->reloadItem($editEvent->getItemId());
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            ItemAddEvent::class => 'reloadEvent',
            ItemEditEvent::class => 'reloadItemEvent'
        ];
    }
}


class SidebarTemplate extends Template
{
    /** @var ItemsList[] */
    public array $lists;

    public NavTemplate $sidebarNavTemplate;
    public UlWrapperTemplate $ulWrapperTemplate;

}