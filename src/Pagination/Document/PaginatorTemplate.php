<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


use e2221\utils\Html\BaseElement;

class PaginatorTemplate extends BaseElement
{
    protected ?string $elementName='ul';
    public string $defaultClass='pagination';
}