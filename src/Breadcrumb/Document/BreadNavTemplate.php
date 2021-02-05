<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Breadcrumb\Document;


class BreadNavTemplate extends BaseTemplate
{
    protected ?string $elementName='nav';

    public function __construct()
    {
        parent::__construct();
        $this->addHtmlAttribute('aria-label', 'breadcrumb');
    }
}