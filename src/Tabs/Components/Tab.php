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

class Tab extends BaseTemplate
{
    protected ?string $elementName='a';
    public string $defaultClass='nav-link';

    protected string $id;
    protected string $title;

    /** @var bool Print content */
    protected bool $printContent=true;

    /** @var Content[] */
    protected array $contents=[];

    protected TabContentItemTemplate $tabContentContainerTemplate;


    public function __construct(Tabs $tabs, string $id, string $title)
    {
        parent::__construct($tabs);
        $this->id = $id;
        $this->title = $title;
        $this->tabContentContainerTemplate = new TabContentItemTemplate($tabs, $this);
    }

    /**
     * End item - back to tab
     * @return Tabs
     */
    public function getTabs(): Tabs
    {
        return $this->tabs;
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addHtmlAttribute('role', 'tab')
            ->addDataAttribute('toggle-tab-link')
            ->addDataAttribute('id', $this->id)
            ->addDataAttribute('unique-id', $this->tabs->getUniqueId())
            ->setHtmlContent($this->title)
            ->addHtmlAttribute('href', 'javascript:void(0);')
            ->addDataAttribute('tab-href', $this->tabs->link('tab', $this->id));
        if($this->isActive() === true)
            $this->addClass('active');
        if($this->printContent() === true)
            $this->addClass('tab-loaded');
    }

    /**
     * Set print content
     * @param bool $printContent
     * @return Tab
     * @internal
     */
    public function setPrintContent(bool $printContent=true): self
    {
        $this->printContent = $printContent;
        return $this;
    }

    /**
     * @return bool
     * @internal
     */
    public function printContent(): bool
    {
        return $this->printContent;
    }

    /**
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addContent($content, string $name): Content
    {
        return $this->contents[$name] = new Content($this->tabs, $this, $content, $name);
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
     * Tabs content wrapper
     * @return TabContentItemTemplate
     */
    public function getTabContentContainerTemplate(): TabContentItemTemplate
    {
        return $this->tabContentContainerTemplate;
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
     * @return Tab
     */
    public function setActive(): self
    {
        $this->tabs->activeTab = $this->id;
        return $this;
    }

    /**
     * Is this tab active?
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->tabs->getActiveTabId() == $this->id;
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

    /**
     * Get id
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}