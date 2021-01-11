<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Components;


use e2221\BootstrapComponents\Sidebar\Document\ItemsList\ItemsListTitle;
use e2221\BootstrapComponents\Sidebar\Exceptions\SidebarException;
use e2221\BootstrapComponents\Sidebar\Sidebar;
use Nette\SmartObject;

class ItemsList
{
    use SmartObject;

    /** @var Item[] */
    protected array $items=[];

    /** @var ItemsListTitle Title template */
    protected ItemsListTitle $titleTemplate;

    /** @var bool Print list with empty content? */
    public bool $printWithEmptyContent=false;

    protected Sidebar $sidebar;
    protected string $name;
    protected ?string $title;

    public function __construct(Sidebar $sidebar, string $name, ?string $title)
    {
        $this->sidebar = $sidebar;
        $this->titleTemplate = new ItemsListTitle($this);
        $this->name = $name;
        $this->title = $title;
        if(isset($this->title))
            $this->titleTemplate->setTextContent($this->title);
    }

    /**
     * Get title template (automatically hidden for non content case)
     * @return ItemsListTitle
     */
    public function getTitleTemplate(): ItemsListTitle
    {
        return $this->titleTemplate;
    }

    /**
     * Back to sidebar
     * @return Sidebar
     */
    public function backToSidebar(): Sidebar
    {
        return $this->sidebar;
    }

    /**
     * Add item
     * @param string $name
     * @param string|null $title
     * @param string|null $href
     * @return Item
     */
    public function addItem(string $name, ?string $title=null, ?string $href=null)
    {
        $item = $this->items[$name] = new Item($this, $name, $title ?? ucfirst($name), $href);
        $this->sidebar->onItemAdd($item);
        return $item;
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
     * Get single item
     * @param string $name
     * @return Item
     * @throws SidebarException
     */
    public function getItem(string $name): Item
    {
        if(isset($this->items[$name]) === false)
            throw new SidebarException(sprintf('Item [%s] does not exist in Item list [%s]', $name, $this->name));
        return $this->items[$name];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Remove this list
     * @return Sidebar
     */
    public function remove(): Sidebar
    {
        unset($this->getItems()[$this->name]);
        return $this->sidebar;
    }

    /**
     * Set print with empty content
     * @param bool $printWithEmptyContent
     * @return ItemsList
     */
    public function setPrintWithEmptyContent(bool $printWithEmptyContent=true): ItemsList
    {
        $this->printWithEmptyContent = $printWithEmptyContent;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrintWithEmptyContent(): bool
    {
        return $this->printWithEmptyContent;
    }
}