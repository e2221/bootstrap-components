<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Breadcrumb;

use e2221\BootstrapComponents\Breadcrumb\Document\BreadItemTemplate;

class BreadItem
{
    private Breadcrumb $breadcrumb;
    private string $title;
    protected BreadItemTemplate $template;
    private ?string $link;
    private string $id;

    public function __construct(Breadcrumb $breadcrumb, string $id, ?string $title, ?string $link)
    {
        $this->breadcrumb = $breadcrumb;
        $this->title = $title ?? $id;
        $this->template = new BreadItemTemplate();
        $this->link = $link;
        if(is_string($this->link))
            $this->setLink($this->link);
        $this->id = $id;
    }

    /**
     * Set link
     * @param string $link
     * @return BreadItem
     */
    public function setLink(string $link): self
    {
        $this->link = $link;
        $this->template->setLink($link);
        return $this;
    }

    /**
     * Set active
     * @return BreadItem
     */
    public function setActive(): self
    {
        $this->template
            ->addClass('active')
            ->addHtmlAttribute('aria-current', 'page');
        return $this;
    }

    /**
     * Get template
     * @return BreadItemTemplate
     */
    public function getTemplate(): BreadItemTemplate
    {
        return $this->template;
    }
}