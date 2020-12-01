<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination;


use e2221\BootstrapComponents\Pagination\Document\BaseItemTemplate;
use e2221\BootstrapComponents\Pagination\Document\BaseLinkTemplate;
use e2221\BootstrapComponents\Pagination\Document\DocumentTemplate;
use e2221\BootstrapComponents\Pagination\Document\FirstLinkTemplate;
use e2221\BootstrapComponents\Pagination\Document\LastLinkTemplate;
use e2221\BootstrapComponents\Pagination\Document\NextLinkTemplate;
use e2221\BootstrapComponents\Pagination\Document\PaginatorTemplate;
use e2221\BootstrapComponents\Pagination\Document\PreviousLinkTemplate;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Paginator;

class PaginationTemplate extends Template
{
    public PaginatorTemplate $paginatorTemplate;
    public BaseItemTemplate $baseItemTemplate;
    public BaseLinkTemplate $baseLinkTemplate;
    public FirstLinkTemplate $fistLinkTemplate;
    public PreviousLinkTemplate $previousLinkTemplate;
    public NextLinkTemplate $nextLinkTemplate;
    public LastLinkTemplate $lastLinkTemplate;
    public DocumentTemplate $documentTemplate;

    public string $baseUrl;
    public string $basePath;
    public array $flashes;
    public Pagination $control;
    public string $view;
    public ?Paginator $paginator;
    public int $showPagesCount;

    public bool $showFirstLink;
    public bool $showPreviousLink;
    public bool $showNextLink;
    public bool $showLastLink;
}