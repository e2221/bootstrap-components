<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination;

use e2221\BootstrapComponents\Pagination\Document\DocumentTemplate;
use Nette\Application\UI\Control;
use Nette\Utils\Paginator;

class Pagination extends Control
{
    const VIEW_TYPES = [
        'PAGE_OF_PAGES' => 'pageOfPages',
        'PAGES'         => 'pages'
    ];

    const
        SMALL = 'pagination-sm',
        LARGE = 'pagination-lg',
        ALIGN_CENTER = 'justify-content-center',
        ALIGN_END = 'justify-content-end';

    /** @var string Active view type */
    protected string $view = 'pageOfPages';

    /** @var Paginator|null Nette Paginator */
    protected ?Paginator $paginator=null;

    /** @var int Only for PAGES view => show count of pages in selection */
    public int $showPagesCount=3;

    /** @var callable|null On paginate callback function(Paginator $paginator):void  */
    protected $onPaginateCallback=null;

    /** @var bool Link to first page */
    public bool $showFirstLink=true;

    /** @var bool Show link to previous page */
    public bool $showPreviousLink=true;

    /** @var bool Show next link */
    public bool $showNextLink=true;

    /** @var bool Show link to last page */
    public bool $showLastLink=true;

    /** @var bool Show info text on the bottom */
    public bool $showInfoText=true;

    protected DocumentTemplate $documentTemplate;

    public function __construct()
    {
        $this->documentTemplate = new DocumentTemplate($this);
    }

    /**
     * Get document templates
     * @return DocumentTemplate
     */
    public function getDocumentTemplate(): DocumentTemplate
    {
        return $this->documentTemplate;
    }

    /**
     * Signal - paginate
     * @param int $page
     */
    public function handlePaginate(int $page): void
    {
        $this->paginator->page = $page;
        if(is_callable($this->onPaginateCallback))
        {
            $onPaginateFn = $this->onPaginateCallback;
            $onPaginateFn($this->paginator);
        }
        if($this->presenter->isAjax())
        {
            $this->redrawControl('paginatorArea');
            $this->redrawControl('paginator');
        }
    }

    public function render(): void
    {
        $this->template->paginatorTemplate = $this->documentTemplate->getRendererPaginatorTemplate();
        $this->template->baseItemTemplate = $this->documentTemplate->getRendererBaseItemTemplate();
        $this->template->baseLinkTemplate = $this->documentTemplate->getRendererBaseLinkTemplate();
        $this->template->fistLinkTemplate = $this->documentTemplate->getRendererFirstLinkTemplate();
        $this->template->previousLinkTemplate = $this->documentTemplate->getRendererPreviousLinkTemplate();
        $this->template->nextLinkTemplate = $this->documentTemplate->getRendererNextLinkTemplate();
        $this->template->lastLinkTemplate = $this->documentTemplate->getRendererLastLinkTemplate();
        $this->template->documentTemplate = $this->documentTemplate;

        $this->template->showFirstLink = $this->showFirstLink;
        $this->template->showPreviousLink = $this->showPreviousLink;
        $this->template->showNextLink = $this->showNextLink;
        $this->template->showLastLink = $this->showLastLink;
        $this->template->showInfoText = $this->showInfoText;

        $this->template->view = $this->view;
        $this->template->paginator = $this->paginator;
        $this->template->showPagesCount = $this->showPagesCount;
        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
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
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
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
     * @return Paginator|null
     */
    public function getPaginator(): ?Paginator
    {
        return $this->paginator;
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
     * Set on paginate callback function(Paginator $paginator): void
     * @param callable|null $onPaginateCallback
     * @return Pagination
     */
    public function setOnPaginateCallback(?callable $onPaginateCallback): self
    {
        $this->onPaginateCallback = $onPaginateCallback;
        return $this;
    }

    /**
     * Set show first link
     * @param bool $showFirstLink
     * @return Pagination
     */
    public function setShowFirstLink(bool $showFirstLink=true): self
    {
        $this->showFirstLink = $showFirstLink;
        return $this;
    }

    /**
     * Set show previous link
     * @param bool $showPreviousLink
     * @return Pagination
     */
    public function setShowPreviousLink(bool $showPreviousLink=true): self
    {
        $this->showPreviousLink = $showPreviousLink;
        return $this;
    }

    /**
     * Set show next link
     * @param bool $showNextLink
     * @return Pagination
     */
    public function setShowNextLink(bool $showNextLink=true): self
    {
        $this->showNextLink = $showNextLink;
        return $this;
    }

    /**
     * Set show last link
     * @param bool $showLastLink
     * @return Pagination
     */
    public function setShowLastLink(bool $showLastLink=true): self
    {
        $this->showLastLink = $showLastLink;
        return $this;
    }

    /**
     * Set width class
     * @param string $widthClass
     * @return Pagination
     */
    public function setWidth(string $widthClass): self
    {
        $this->documentTemplate->getPaginatorTemplate()->setClass($widthClass);
        return $this;
    }

    /**
     * Set align class
     * @param string $alignClass
     * @return Pagination
     */
    public function setAlign(string $alignClass): self
    {
        $this->documentTemplate->getPaginatorTemplate()->setClass($alignClass);
        return $this;
    }

    /**
     * Set show info text
     * @param bool $showInfoText
     * @return Pagination
     */
    public function setShowInfoText(bool $showInfoText=true): self
    {
        $this->showInfoText = $showInfoText;
        return $this;
    }
}