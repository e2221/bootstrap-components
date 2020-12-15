<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components\Buttons;


class FooterCloseButton extends BaseButton
{
    protected ?string $elementName='button';
    public string $defaultClass='btn';
    public string $class='btn-secondary';
    public bool $hidden=true;

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addDataAttribute('dismiss', 'modal')
            ->addHtmlAttribute('type', 'button')
            ->addTextContent('Close');
    }
}