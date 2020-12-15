<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components\Buttons;


class HeaderCloseButton extends BaseButton
{
    protected ?string $elementName='button';
    public string $defaultClass='close';

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addDataAttribute('dismiss', 'modal')
            ->addHtmlAttribute('aria-label', 'Close')
            ->addHtmlAttribute('type', 'button')
            ->addSpanElement(null, ['aria-hidden'=>'true'])
                ->addHtml('&times;');
    }
}