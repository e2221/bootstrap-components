<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal;


use e2221\BootstrapComponents\Modal\Components\BodyTemplate;
use e2221\BootstrapComponents\Modal\Components\Buttons\FooterCloseButton;
use e2221\BootstrapComponents\Modal\Components\Buttons\HeaderCloseButton;
use e2221\BootstrapComponents\Modal\Components\Buttons\OpenModalButton;
use e2221\BootstrapComponents\Modal\Components\FooterTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTemplate;
use e2221\BootstrapComponents\Modal\Components\HeaderTitleTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalContentTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalDialogTemplate;
use e2221\BootstrapComponents\Modal\Components\ModalMainTemplate;
use e2221\BootstrapComponents\Modal\Content\Content;
use e2221\utils\Html\BaseElement;
use InvalidArgumentException;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;
use Nette\Utils\Random;

class Modal extends Control
{
    const
        MODAL_WIDTH_XL = 'modal-xl',
        MODAL_WIDTH_LG = 'modal-lg',
        MODAL_WIDTH_SM = 'modal-sm',
        SNIPPET_AREA = 'modalArea',
        SNIPPET_HEADER = 'modalHeader',
        SNIPPET_BODY = 'modalBody',
        SNIPPET_FOOTER = 'modalFooter',
        SNIPPET_MODAL = 'modal',
        SNIPPET_OPEN_BUTTON = 'openModalButton';

    /** @var Components\ModalMainTemplate Modal template */
    protected Components\ModalMainTemplate $modalTemplate;

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
    protected $bodyWrapper=null;

    /** @var Content[] Body content */
    protected array $content=[];

    /** @var BaseElement|Html|null Wrapper of footer */
    protected $footerWrapper=null;

    /** @var Content[] Footer content */
    protected array $footerContent=[];

    /** @var BaseElement|Html|null Wrapper of header */
    protected $headerWrapper=null;

    /** @var Content[] Header content */
    protected array $headerContent=[];

    /** @var FooterCloseButton Footer close button */
    protected FooterCloseButton $footerCloseButton;

    /** @var HeaderCloseButton Header close button */
    protected HeaderCloseButton $headerCloseButton;

    /** @var OpenModalButton Open modal button */
    protected OpenModalButton $openModalButton;

    /** @var bool  */
    public bool $printOpenButton=false;

    /** @var string Modal id */
    protected string $modalId;

    public function __construct()
    {
        $this->modalTemplate = new ModalMainTemplate($this);
        $this->bodyTemplate = new BodyTemplate();
        $this->footerTemplate = new FooterTemplate();
        $this->headerTemplate = new HeaderTemplate();
        $this->headerTitleTemplate = new HeaderTitleTemplate();
        $this->contentTemplate = new ModalContentTemplate();
        $this->dialogTemplate = new ModalDialogTemplate();
        $this->footerCloseButton = new FooterCloseButton();
        $this->headerCloseButton = new HeaderCloseButton();
        $this->openModalButton = new OpenModalButton($this);
        $this->modalId = sprintf('modal-%s', Random::generate(5, 'A-Z'));
    }

    /**
     * Get modal id
     * @return string
     */
    public function getModalId(): string
    {
        return $this->modalId;
    }

    /**
     * Set modal id
     * @param string $modalId
     * @return Modal
     */
    public function setModalId(string $modalId): self
    {
        $this->modalId = $modalId;
        return $this;
    }

    /**
     * Set print open button
     * @param bool $printOpenButton
     * @return Modal
     */
    public function setPrintOpenButton(bool $printOpenButton=true): self
    {
        $this->printOpenButton = $printOpenButton;
        return $this;
    }

    /**
     * Render default
     */
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
        $this->template->headerCloseButton = $this->headerCloseButton;
        $this->template->footerCloseButton = $this->footerCloseButton;
        $this->template->bodyWrapper = $this->bodyWrapper;
        $this->template->headerWrapper = $this->headerWrapper;
        $this->template->footerWrapper = $this->footerWrapper;
        $this->template->content = $this->content;
        $this->template->headerContent = $this->headerContent;
        $this->template->footerContent = $this->footerContent;

        if($this->printOpenButton === true)
            $this->template->openModalButton = $this->openModalButton;

        $this->template->setFile(__DIR__ . '/templates/default.latte');
        $this->template->render();
    }

    /**
     * Render button
     */
    public function renderButton(): void
    {
        $this->template->openModalButton = $this->openModalButton;
        $this->template->setFile(__DIR__ . '/templates/button.latte');
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
     * HEADER Wrapper
     * ******************************************************************************
     *
     */

    /**
     * Set Header wrapper
     * @param BaseElement|Html|null $headerWrapper
     * @return Modal
     */
    public function setHeaderWrapper($headerWrapper): self
    {
        $this->headerWrapper = $headerWrapper;
        return $this;
    }

    /**
     * Get header wrapper
     * @return BaseElement|Html|null
     */
    public function getHeaderWrapper()
    {
        return $this->headerWrapper;
    }

    /**
     * FOOTER Wrapper
     * ******************************************************************************
     *
     */

    /**
     * Set footer wrapper
     * @param BaseElement|Html|null $footerWrapper
     * @return Modal
     */
    public function setFooterWrapper($footerWrapper): self
    {
        $this->footerWrapper = $footerWrapper;
        return $this;
    }

    /**
     * Get footer wrapper
     * @return BaseElement|Html|null
     */
    public function getFooterWrapper()
    {
        return $this->footerWrapper;
    }


    /**
     * Content
     * ******************************************************************************
     *
     */

    /**
     * Add content of body
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addContent($content, string $name): Content
    {
        return $this->content[$name] = new Content($this, $content, $name);
    }

    /**
     * Add content of header
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addHeaderContent($content, string $name): Content
    {
        return $this->headerContent[$name] = new Content($this, $content, $name);
    }

    /**
     * Add content of footer
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     * @return Content
     */
    public function addFooterContent($content, string $name): Content
    {
        return $this->footerContent[$name] = new Content($this, $content, $name);
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
     * Set Header title
     * @param string $title
     * @return Modal
     */
    public function setTitle(string $title): self
    {
        $this->getHeaderTitleTemplate()->setTextContent($title);
        return $this;
    }

    /**
     * Set show top close button
     * @param bool $showHeaderCloseButton
     * @return Modal
     */
    public function setShowHeaderCloseButton(bool $showHeaderCloseButton=true): self
    {
        $this->getHeaderCloseButton()->setHidden($showHeaderCloseButton);
        return $this;
    }

    /**
     * Set show footer close button
     * @param bool $showFooterCloseButton
     * @return Modal
     */
    public function setShowFooterCloseButton(bool $showFooterCloseButton=true): self
    {
        $this->getFooterCloseButton()->setHidden($showFooterCloseButton);
        return $this;
    }


    /**
     * TEMPLATE GETTERS
     * ******************************************************************************
     *
     */

    /**
     * @return Components\ModalMainTemplate
     */
    public function getModalTemplate(): Components\ModalMainTemplate
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

    /**
     * @return FooterCloseButton
     */
    public function getFooterCloseButton(): FooterCloseButton
    {
        return $this->footerCloseButton;
    }

    /**
     * @return HeaderCloseButton
     */
    public function getHeaderCloseButton(): HeaderCloseButton
    {
        return $this->headerCloseButton;
    }


    /**
     * Reloading snippets
     * ******************************************************************************
     *
     */

    /**
     * Reload
     * @param string|array|null $snippets
     */
    public function reload($snippets=null): void
    {
        if($this->getPresenter()->isAjax())
        {
            $this->redrawControl(self::SNIPPET_AREA);
            if(is_null($snippets)){
                $this->redrawControl(self::SNIPPET_MODAL);
            }else if(is_string($snippets))
            {
                $this->redrawControl($snippets);
            }else{
                foreach($snippets as $snippet)
                    $this->redrawControl($snippet);
            }
        }
    }

    /**
     * Reload modal body
     */
    public function reloadBody(): void
    {
        $this->reload(self::SNIPPET_BODY);
    }

    /**
     * Reload footer
     */
    public function reloadFooter(): void
    {
        $this->reload(self::SNIPPET_FOOTER);
    }

    /**
     * Reload Header
     */
    public function reloadHeader(): void
    {
        $this->reload(self::SNIPPET_FOOTER);
    }

    /**
     * Reload open modal button
     */
    public function reloadOpenButton(): void
    {
        $this->reload(self::SNIPPET_OPEN_BUTTON);
    }

}