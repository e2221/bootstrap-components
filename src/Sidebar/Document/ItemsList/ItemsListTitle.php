<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document\ItemsList;


class ItemsListTitle extends BaseListTemplate
{
    protected ?string $elementName='h6';
    public string $defaultClass='sidebar-heading d-flex';
    public string $class='justify-content-between align-items-center px-3 mt-4 mb-1 text-muted';

    public function beforeRender(): void
    {
        parent::beforeRender();
        if(empty($this->element->getText()) === true)
            $this->setHidden();
    }
}