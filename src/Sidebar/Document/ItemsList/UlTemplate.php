<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document;


use e2221\BootstrapComponents\Sidebar\Document\ItemsList\BaseListTemplate;

class UlTemplate extends BaseListTemplate
{
    protected ?string $elementName='ul';
    public string $defaultClass='nav flex-column';
}