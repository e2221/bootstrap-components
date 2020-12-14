<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components;


use e2221\utils\Html\BaseElement;

class HeaderTemplate extends BaseElement
{
    protected ?string $elementName='div';
    public string $defaultClass='modal-header';
}