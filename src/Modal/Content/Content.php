<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Content;


use e2221\BootstrapComponents\Modal\Modal;
use e2221\utils\Html\BaseElement;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class Content extends BaseElement
{
    /** @var Modal  */
    protected Modal $modal;

    /** @var null|BaseElement|Html Wrapper of content */
    protected $contentWrapper=null;

    /** @var IComponent|string|Html|BaseElement */
    protected $content;

    /** @var string  */
    protected string $name;

    /**
     * Content constructor.
     * @param Modal $modal
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     */
    public function __construct(Modal $modal, $content, $name)
    {
        parent::__construct();
        if($content instanceof IComponent && is_null($content->getPresenterIfExists()))
        {
            $modal->addComponent($content, $name);
        }
        $this->name = $name;
        $this->content = $content;
        $this->modal = $modal;
    }

    /**
     * End content - go back to modal
     * @return Modal
     */
    public function endContent(): Modal
    {
        return $this->modal;
    }

    /**
     * @return BaseElement|Html|null
     */
    public function getContentWrapper()
    {
        return $this->contentWrapper;
    }

    /**
     * @return BaseElement|IComponent|Html|string
     */
    public function getContent()
    {
        return $this->content;
    }

}