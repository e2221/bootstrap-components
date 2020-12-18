<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


use e2221\BootstrapComponents\Tabs\Tabs;

class TabHeaderTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='nav';


    public function __construct(Tabs $tabs)
    {
        parent::__construct($tabs);
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $style = $this->tabs->getStyle();
        switch ($style)
        {
            case 'pill':
                $this->addClass('nav-pills');
                break;
            default:
                $this->addClass('nav-tabs');
        }
        $this->addHtmlAttribute('role', 'tablist');
    }
}