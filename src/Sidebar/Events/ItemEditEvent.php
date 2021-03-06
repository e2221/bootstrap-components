<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Events;


class ItemEditEvent
{
    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }
}