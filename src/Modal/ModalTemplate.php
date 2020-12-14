<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal;


use Nette\Bridges\ApplicationLatte\Template;

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
    public Components\ModalTemplate $modalTemplate;
    public Components\BodyTemplate $bodyTemplate;
    public Components\FooterTemplate $footerTemplate;
    public Components\HeaderTemplate $headerTemplate;
    public Components\HeaderTitleTemplate $headerTitleTemplate;
    public Components\ModalContentTemplate $contentTemplate;
    public Components\ModalDialogTemplate $dialogTemplate;

    /** @var string[] */
    public array $templates;
}