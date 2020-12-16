<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


use e2221\BootstrapComponents\Tabs\Content\Content;
use e2221\BootstrapComponents\Tabs\Exceptions\TabsException;
use e2221\BootstrapComponents\Tabs\Tabs;
use e2221\utils\Html\BaseElement;
use Nette\Application\UI\InvalidLinkException;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class NavItem extends BaseTemplate
{
    protected ?string $elementName='a';
    public string $defaultClass='nav-link';

    protected string $id;
    protected string $title;

    /** @var Content[] */
    protected array $contents=[];

    private Tabs $tabs;

    public function __construct(Tabs $tabs, string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->tabs = $tabs;
        parent::__construct();
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addDataAttribute('toggle', 'tab')
            ->addHtmlAttribute('role', 'tab');
    }

    /**
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addContent($content, string $name): Content
    {
        return $this->contents[$name] = new Content($this->tabs, $content, $name);
    }

    /**
     * Get content
     * @param string $name
     * @return Content
     * @throws TabsException
     */
    public function getContent(string $name): Content
    {
        if(isset($this->contents[$name]) === false)
            throw new TabsException(sprintf('Content [%s] does not exist in tab id [%s]', $name, $this->id));
        return $this->contents[$name];
    }

    /**
     * Get contents
     * @return Content[]
     * @internal
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * Set this tab active
     * @return $this
     */
    public function setActive(): self
    {
        $this->tabs->activeTab = $this->id;
        return $this;
    }

    /**
     * Get active link
     * @return string
     * @throws InvalidLinkException
     * @internal
     */
    public function getActiveLink(): string
    {
        return $this->tabs->link('tab!', $this->id);
    }

}