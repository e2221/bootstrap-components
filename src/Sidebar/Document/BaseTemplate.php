<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document;


use e2221\BootstrapComponents\Sidebar\Sidebar;
use e2221\utils\Html\BaseElement;

class BaseTemplate extends BaseElement
{
    protected Sidebar $sidebar;

    public function __construct(Sidebar $sidebar)
    {
        parent::__construct();
        $this->sidebar = $sidebar;
    }

}