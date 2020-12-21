<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document;


use e2221\utils\Html\HrefElement;

class ItemLinkTemplate extends HrefElement
{
    public string $defaultClass='nav-link';

    /**
     * Set this link as active
     * @param bool $active
     * @return ItemLinkTemplate
     */
    public function setActive(bool $active=true): self
    {
        if($active===true)
            $this->addClass('active');
        return $this;
    }
}