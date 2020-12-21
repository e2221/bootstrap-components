<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar;

use e2221\BootstrapComponents\Sidebar\Components\ItemsList;
use e2221\BootstrapComponents\Sidebar\Document\NavTemplate;
use e2221\BootstrapComponents\Sidebar\Document\UlWrapperTemplate;
use e2221\BootstrapComponents\Sidebar\Exceptions\SidebarException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

class Sidebar extends Control
{
    /** @var ItemsList[] Lists of items */
    protected array $lists=[];

    protected NavTemplate $navTemplate;
    protected UlWrapperTemplate $ulWrapperTemplate;

    public function __construct()
    {
        $this->navTemplate = new NavTemplate($this);
        $this->ulWrapperTemplate = new UlWrapperTemplate($this);
    }

    public function addList(string $name, ?string $title=null): ItemsList
    {
         return $this->lists[$name] = new ItemsList($this, $name, $title);
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

    public function render(): void
    {
        $this->template->lists = $this->getLists();
        $this->template->sidebarNavTemplate = $this->navTemplate;
        $this->template->ulWrapperTemplate = $this->ulWrapperTemplate;


        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
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
}


class SidebarTemplate extends Template
{
    /** @var ItemsList[] */
    public array $lists;

    public NavTemplate $sidebarNavTemplate;
    public UlWrapperTemplate $ulWrapperTemplate;

}