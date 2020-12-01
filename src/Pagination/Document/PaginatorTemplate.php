<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


use e2221\utils\Html\BaseElement;

class PaginatorTemplate extends BaseElement
{
    const
        SMALL = 'pagination-sm',
        LARGE = 'pagination-lg';

    protected ?string $elementName='ul';
    public string $defaultClass='pagination';

    /**
     * Set pagination size class
     * @param string $sizeClass
     * @return PaginatorTemplate
     */
    public function setPaginationSize(string $sizeClass): self
    {
        $this->setClass($sizeClass);
        return $this;
    }
}