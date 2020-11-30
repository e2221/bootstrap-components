<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination;


use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Paginator;

class PaginationTemplate extends Template
{
    public string $baseUrl;
    public string $basePath;
    public array $flashes;
    public Pagination $control;
    public string $view;
    public ?Paginator $paginator;
    public int $showPagesCount;
}