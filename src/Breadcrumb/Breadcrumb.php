<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Breadcrumb;


use e2221\BootstrapComponents\Breadcrumb\Document\BreadNavTemplate;
use e2221\BootstrapComponents\Breadcrumb\Document\BreadOlTemplate;
use Nette\Application\UI\Control;

class Breadcrumb extends Control
{
    /** @var BreadItem[]  */
    protected array $items=[];

    private BreadNavTemplate $navTemplate;
    private BreadOlTemplate $olTemplate;

    public function __construct()
    {
        $this->navTemplate = new BreadNavTemplate();
        $this->olTemplate = new BreadOlTemplate();
    }

    /**
    * Renderer
    */
    public function render(): void
    {
        $this->template->navTemplate = $this->navTemplate;
        $this->template->olTemplate = $this->olTemplate;
        $this->template->items = $this->items;
        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Add item
     * @param string $id
     * @param string|null $title
     * @param string|null $link
     * @return BreadItem
     */
    public function addItem(string $id, ?string $title, ?string $link=null): BreadItem
    {
        return $this->items[$id] = new BreadItem($this, $id, $title, $link);
    }

    /**
     * @return BreadItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get item
     * @param string $id
     * @return BreadItem|null
     */
    public function getItem(string $id): ?BreadItem
    {
        if(isset($this->items[$id]))
            return $this->items[$id];
        return null;
    }

}

/**
 * Template
 * @method mixed clamp($value, $min, $max)
 */
class BreadcrumbTemplate extends \Nette\Bridges\ApplicationLatte\Template
{
    use \Nette\SmartObject;
    public Breadcrumb $control;
    public \Nette\Security\User $user;
    public string $baseUrl;
    public string $basePath;
    public array $flashes;

    /** @var BreadItem[] */
    public array $items;

    public BreadNavTemplate $navTemplate;
    public BreadOlTemplate $olTemplate;
}