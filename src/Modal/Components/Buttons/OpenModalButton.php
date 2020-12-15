<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components\Buttons;


use e2221\BootstrapComponents\Modal\Modal;

class OpenModalButton extends BaseButton
{
    protected ?string $elementName='a';
    public string $defaultClass='btn';
    protected string $class='btn-sm btn-secondary';
    private Modal $modal;


    public function __construct(Modal $modal)
    {
        parent::__construct();
        $this->modal = $modal;
        $this->setTextContent('Open');
    }

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addDataAttribute('toggle', 'modal')
            ->addDataAttribute('target', sprintf('#%s', $this->modal->getModalId()))
            ->addHtmlAttribute('href', 'javascript:void(0)');
    }
}