<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


class HorizontalRowTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='row';
    public bool $hidden=true;

    public function beforeRender(): void
    {
        parent::beforeRender();
        if($this->tabs->getLayout() == 'horizontal')
            $this->hidden = false;
    }
}