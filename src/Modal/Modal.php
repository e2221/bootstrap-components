<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal;


use e2221\BootstrapComponents\Modal\Components\BodyTemplate;
use e2221\BootstrapComponents\Modal\Components\FooterTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTitleTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalContentTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalDialogTemplate;
use e2221\BootstrapComponents\Modal\Content\Content;
use e2221\HtmElement\BaseElement;
use InvalidArgumentException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class Modal extends Control
{
    const
        MODAL_WIDTH_XL = 'modal-xl',
        MODAL_WIDTH_LG = 'modal-lg',
        MODAL_WIDTH_SM = 'modal-sm';

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

    /** @var string[] Paths to external templates with blocks */
    protected array $templates=[];

    /** @var BaseElement|Html|null Wrapper of content */
    protected  $bodyWrapper=null;

    /** @var Content[] Body content */
    protected array $content=[];

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
        $this->template->templates = $this->templates;
        $this->template->modalTemplate = $this->modalTemplate;
        $this->template->bodyTemplate = $this->bodyTemplate;
        $this->template->footerTemplate = $this->footerTemplate;
        $this->template->headerTemplate = $this->headerTemplate;
        $this->template->headerTitleTemplate = $this->headerTitleTemplate;
        $this->template->contentTemplate = $this->contentTemplate;
        $this->template->dialogTemplate = $this->dialogTemplate;

        $this->template->bodyWrapper = $this->bodyWrapper;
        $this->template->content = $this->content;

        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Add custom template with blocks
     * @param string|Template $path
     */
    public function addTemplate($path): void
    {
        if ($path instanceof Template) {
            $path = $path->getFile();
        }
        if (!file_exists($path)) {
            throw new InvalidArgumentException("Template '{$path}' does not exist.");
        }
        $this->templates[] = $path;
    }

    /**
     * BODY Wrapper
     * ******************************************************************************
     *
     */

    /**
     * Set body wrapper
     * @param BaseElement|Html|null $bodyWrapper
     * @return Modal
     */
    public function setBodyWrapper($bodyWrapper): self
    {
        $this->bodyWrapper = $bodyWrapper;
        return $this;
    }

    /**
     * @return BaseElement|Html|null
     */
    public function getBodyWrapper()
    {
        return $this->bodyWrapper;
    }

    /**
     * Content
     * ******************************************************************************
     *
     */

    /**
     * @param  IComponent|string|Html|\e2221\utils\Html\BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addContent($content, string $name): Content
    {
        return $this->content[$name] = new Content($this, $content, $name);
    }

    /**
     * FEATURES - MODAL STYLING
     * ******************************************************************************
     *
     */

    /**
     * Set static backdrop
     * @param bool $staticBackdrop
     * @return Modal
     */
    public function setStaticBackdrop(bool $staticBackdrop=true): self
    {
        $this->getModalTemplate()->setStaticBackdrop($staticBackdrop);
        return $this;
    }

    /**
     * Set scrollable long content
     * @param bool $scrollableLongContent
     * @return Modal
     */
    public function setScrollableLongContent(bool $scrollableLongContent=true): self
    {
        $this->getDialogTemplate()->setScrollingLongContent($scrollableLongContent);
        return $this;
    }

    /**
     * Set vertically centered content
     * @param bool $verticallyCentered
     * @return Modal
     */
    public function setVerticallyCentered(bool $verticallyCentered=true): self
    {
        $this->getDialogTemplate()->setVerticallyCentered($verticallyCentered);
        return $this;
    }

    /**
     * Set width
     * @param string $widthClass
     * @return Modal
     */
    public function setWidth(string $widthClass): self
    {
        $this->getDialogTemplate()->setModalWidth($widthClass);
        return $this;
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