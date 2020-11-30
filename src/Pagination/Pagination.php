<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination;


use Nette\Application\UI\Control;
use Nette\Utils\Paginator;

class Pagination extends Control
{
    const VIEW_TYPES = [
        'PAGE_OF_PAGES' => 'pageOfPages',
        'PAGES'         => 'pages'
    ];

    /** @var string Active view type */
    protected string $view = 'pageOfPages';

    /** @var Paginator|null Nette Paginator */
    protected ?Paginator $paginator=null;

    /** @var int @persistent */
    public int $activePage=1;

    /** @var int Only for PAGES view => show count of pages in selection */
    public int $showPagesCount=3;

    /** @var callable|null Link to change page function(int $activePage, Paginator $paginator):string */
    protected $linkCallback=null;


    public function render(): void
    {
        $this->template->activePage = $this->activePage;
        $this->template->view = $this->view;
        $this->template->paginator = $this->paginator;
        $this->template->showPagesCount = $this->showPagesCount;

        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Get link
     * @param int $page
     * @return string|null
     */
    public function getLink(int $page): ?string
    {
        if(is_callable($this->linkCallback))
        {
            $getLinkFn = $this->linkCallback;
            return $getLinkFn($page, $this->paginator);
        }
        return null;
    }

    /**
     * Set view type
     * @param string $view
     * @return Pagination
     */
    public function setView(string $view): self
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Set Nette paginator
     * @param Paginator|null $paginator
     * @return Pagination
     */
    public function setPaginator(?Paginator $paginator): self
    {
        $this->paginator = $paginator;
        return $this;
    }

    /**
     * Set active page
     * @param int $activePage
     * @return Pagination
     */
    public function setActivePage(int $activePage): self
    {
        $this->activePage = $activePage;
        return $this;
    }

    /**
     * Set show pages count (buttons to pages)
     * @param int $showPagesCount
     * @return Pagination
     */
    public function setShowPagesCount(int $showPagesCount): self
    {
        $this->showPagesCount = $showPagesCount;
        return $this;
    }

    /**
     * Set link callback
     * @param callable|null $linkCallback function(int $activePage, Paginator $paginator):string
     * @return Pagination
     */
    public function setLinkCallback(?callable $linkCallback): self
    {
        $this->linkCallback = $linkCallback;
        return $this;
    }


}