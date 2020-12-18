<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


use e2221\BootstrapComponents\Tabs\Tabs;
use e2221\utils\Html\BaseElement;

class BaseTemplate extends BaseElement
{
    protected Tabs $tabs;

    public function __construct(Tabs $tabs)
    {
        parent::__construct();
        $this->tabs = $tabs;
    }

    /**
     * Go back to template
     * @return Tabs
     */
    public function endTemplate(): Tabs
    {
        return $this->tabs;
    }
}