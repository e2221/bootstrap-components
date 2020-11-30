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

    /** @var int Only for PAGES view => show count of pages in selection */
    public int $showPagesCount=3;

    /** @var callable|null On paginate callback function(Paginator $paginator):void  */
    protected $onPaginateCallback=null;

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


}