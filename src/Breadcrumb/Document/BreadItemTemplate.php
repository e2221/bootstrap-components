<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Breadcrumb\Document;


use e2221\utils\Html\HrefElement;

class BreadItemTemplate extends HrefElement
{
    protected ?string $elementName='li';
    public string $defaultClass='breadcrumb-item';
}