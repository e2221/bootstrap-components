<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Components;

use e2221\BootstrapComponents\Sidebar\Exceptions\SidebarException;
use e2221\utils\Html\HrefElement;

class Item extends HrefElement
{
    public string $defaultClass='nav-link';

    protected string $name;
    protected string $title;
    protected ?string $href;
    protected ItemsList $itemsList;

    /** @var null|callable on click callback: function(Sidebar $sidebar, Item $item, ItemList $itemList): void */
    protected $onClickCallback=null;

    protected bool $active=false;

    public function __construct(ItemsList $itemsList, string $name, string $title, ?string $href=null)
    {
        parent::__construct();
        $this->name = $name;
        $this->title = $title;
        $this->href = $href;
        $this->itemsList = $itemsList;
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->setTextContent($this->title);
        if(is_string($this->href))
            $this->setLink($this->href);
        if($this->active === true)
            $this->addClass('active');
        if(is_callable($this->onClickCallback))
            $this->setLink($this->itemsList->backToSidebar()->link('link', $this->itemsList->getName(), $this->name));
    }

    /**
     * Get parent list
     * @return ItemsList
     */
    public function getList(): ItemsList
    {
        return $this->itemsList;
    }

    /**
     * Simulate click on this item
     */
    public function click(): void
    {
        $this->itemsList->backToSidebar()->handleLink($this->itemsList->getName(), $this->getName());
    }

    /**
     * Set on click callback
     * @param callable|null $onClickCallback function(Sidebar $sidebar, Item $item, ItemList $itemList): void
     * @return Item
     */
    public function setOnClickCallback(?callable $onClickCallback): self
    {
        $this->onClickCallback = $onClickCallback;
        return $this;
    }

    /**
     * @return callable|null
     */
    public function getOnClickCallback(): ?callable
    {
        return $this->onClickCallback;
    }

    /**
     * Set this link as active
     * @param bool $active
     * @return Item
     */
    public function setActive(bool $active=true): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Is this item active?
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Back to list
     * @return ItemsList
     */
    public function backToList(): ItemsList
    {
        return $this->itemsList;
    }

    /**
     * Get unique name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get href
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * Set title
     * @param string $title
     * @return Item
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Reload this item
     * @throws SidebarException
     */
    public function reload(): void
    {
        $this->getList()->backToSidebar()
            ->reloadItem($this);
    }
}