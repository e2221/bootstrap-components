<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document\ItemsList;


use e2221\BootstrapComponents\Sidebar\Components\ItemsList;
use e2221\utils\Html\BaseElement;

class BaseListTemplate extends BaseElement
{
    protected ItemsList $itemsList;

    public function __construct(ItemsList $itemsList)
    {
        parent::__construct();
        $this->itemsList = $itemsList;
    }

    /**
     * Go back to items list
     * @return ItemsList
     */
    public function backToItemsList(): ItemsList
    {
        return $this->itemsList;
    }
}