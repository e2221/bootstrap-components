<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;

use e2221\BootstrapComponents\Pagination\Pagination;
use e2221\utils\Html\HrefElement;

class BaseLinkTemplate extends HrefElement
{
    protected ?string $elementName='a';
    public string $defaultClass='page-link';
    protected Pagination $pagination;

    public function __construct(Pagination $pagination)
    {
        parent::__construct();
        $this->pagination = $pagination;
    }

    /**
     * Add title
     * @param string|null $title
     * @return BaseLinkTemplate
     */
    public function addTitle(?string $title = null): BaseLinkTemplate
    {
        parent::addTitle($title);
        $this->addHtmlAttribute('aria-label', $title);
        return $this;
    }

}