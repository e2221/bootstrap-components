<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal;


use e2221\BootstrapComponents\Modal\Components\BodyTemplate;
use e2221\BootstrapComponents\Modal\Components\FooterTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTitleTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalContentTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalDialogTemplate;
use Nette\Application\UI\Control;

class Modal extends Control
{
    /** @var Components\ModalTemplate Modal template */
    protected Components\ModalTemplate $modalTemplate;

    /** @var BodyTemplate Body template */
    protected BodyTemplate $bodyTemplate;

    /** @var FooterTemplate Footer template */
    protected FooterTemplate $footerTemplate;

    /** @var HeaderTemplate Header template */
    protected HeaderTemplate $headerTemplate;

    /** @var HeaderTitleTemplate Title template */
    protected HeaderTitleTemplate $headerTitleTemplate;

    /** @var ModalContentTemplate Content template */
    protected ModalContentTemplate $contentTemplate;

    /** @var ModalDialogTemplate Dialog template */
    protected ModalDialogTemplate $dialogTemplate;

    public function __construct()
    {
        $this->modalTemplate = new \e2221\BootstrapComponents\Modal\Components\ModalTemplate();
        $this->bodyTemplate = new BodyTemplate();
        $this->footerTemplate = new FooterTemplate();
        $this->headerTemplate = new HeaderTemplate();
        $this->headerTitleTemplate = new HeaderTitleTemplate();
        $this->contentTemplate = new ModalContentTemplate();
        $this->dialogTemplate = new ModalDialogTemplate();
    }

    public function render(): void
    {
        $this->template->modalTemplate = $this->modalTemplate;
        $this->template->bodyTemplate = $this->bodyTemplate;
        $this->template->footerTemplate = $this->footerTemplate;
        $this->template->headerTemplate = $this->headerTemplate;
        $this->template->headerTitleTemplate = $this->headerTitleTemplate;
        $this->template->contentTemplate = $this->contentTemplate;
        $this->template->dialogTemplate = $this->dialogTemplate;

        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }



    /**
     * TEMPLATE GETTERS
     * ******************************************************************************
     *
     */

    /**
     * @return Components\ModalTemplate
     */
    public function getModalTemplate(): Components\ModalTemplate
    {
        return $this->modalTemplate;
    }

    /**
     * @return BodyTemplate
     */
    public function getBodyTemplate(): BodyTemplate
    {
        return $this->bodyTemplate;
    }

    /**
     * @return FooterTemplate
     */
    public function getFooterTemplate(): FooterTemplate
    {
        return $this->footerTemplate;
    }

    /**
     * @return HeaderTemplate
     */
    public function getHeaderTemplate(): HeaderTemplate
    {
        return $this->headerTemplate;
    }

    /**
     * @return HeaderTitleTemplate
     */
    public function getHeaderTitleTemplate(): HeaderTitleTemplate
    {
        return $this->headerTitleTemplate;
    }

    /**
     * @return ModalContentTemplate
     */
    public function getContentTemplate(): ModalContentTemplate
    {
        return $this->contentTemplate;
    }

    /**
     * @return ModalDialogTemplate
     */
    public function getDialogTemplate(): ModalDialogTemplate
    {
        return $this->dialogTemplate;
    }


}