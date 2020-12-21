<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Components;


use e2221\utils\Html\HrefElement;
use Nette\SmartObject;

class Item extends HrefElement
{
    use SmartObject;

    protected string $name;
    protected string $title;
    protected ?string $href;
    private ItemsList $itemsList;

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
        if(is_string($this->href))
            $this->setLink($this->href);
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }



}