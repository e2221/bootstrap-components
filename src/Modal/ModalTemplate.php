<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal;


use e2221\BootstrapComponents\Modal\Components\Buttons\FooterCloseButton;
use e2221\BootstrapComponents\Modal\Components\Buttons\HeaderCloseButton;
use e2221\BootstrapComponents\Modal\Components\Buttons\OpenModalButton;
use e2221\BootstrapComponents\Modal\Content\Content;
use e2221\utils\Html\BaseElement;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Utils\Html;

/**
 * @method bool isLinkCurrent(string $destination = null, $args = [])
 * @method bool isModuleCurrent(string $module)
 */
class ModalTemplate extends Template
{
    public string $baseUrl;
    public string $basePath;
    public array $flashes;
    public Modal $control;
    public Components\ModalMainTemplate $modalTemplate;
    public Components\BodyTemplate $bodyTemplate;
    public Components\FooterTemplate $footerTemplate;
    public Components\HeaderTemplate $headerTemplate;
    public Components\HeaderTitleTemplate $headerTitleTemplate;
    public Components\ModalContentTemplate $contentTemplate;
    public Components\ModalDialogTemplate $dialogTemplate;
    public HeaderCloseButton $headerCloseButton;
    public FooterCloseButton $footerCloseButton;
    public OpenModalButton $openModalButton;
    public string $modalId;

    /** @var string[] */
    public array $templates;

    /** @var Content[] */
    public array $content;

    /** @var Content[] */
    public array $headerContent;

    /** @var Content[] */
    public array $footerContent;

    /** @var null|Html|BaseElement */
    public $bodyWrapper;

    /** @var null|Html|BaseElement */
    public $headerWrapper;

    /** @var null|Html|BaseElement */
    public $footerWrapper;
}