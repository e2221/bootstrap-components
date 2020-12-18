<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Components;


class HorizontalHeaderColTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public bool $hidden=true;
    public string $class='col-3';

    public function beforeRender(): void
    {
        parent::beforeRender();
        if($this->tabs->getLayout() == 'horizontal')
            $this->hidden = false;
    }
}