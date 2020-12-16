<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Tabs\Content;


use e2221\BootstrapComponents\Tabs\Tabs;
use e2221\utils\Html\BaseElement;
use Nette\Application\UI\Component;
use Nette\ComponentModel\IComponent;
use Nette\Utils\Html;

class Content extends BaseElement
{
    protected Tabs $tabs;

    /** @var IComponent|string|Html|BaseElement */
    protected $content;

    protected string $name;

    /**
     * Content constructor.
     * @param Tabs $tabs
     * @param IComponent|string|Html|BaseElement $content
     * @param string $name
     */
    public function __construct(Tabs $tabs, $content, string $name)
    {
        parent::__construct();
        $this->tabs = $tabs;
        $this->content = $content;
        $this->name = $name;
        if($this->content instanceof Component && is_null($this->content->getPresenterIfExists()))
            $tabs->addComponent($this->content, $name);
    }

    /**
     * End content - go back to tabs
     * @return Tabs
     */
    public function endContent(): Tabs
    {
        return $this->tabs;
    }

    /**
     * Get content
     * @return BaseElement|IComponent|Html|string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Render content - internal
     * @return BaseElement|IComponent|Html|string|null
     * @internal
     */
    public function renderContent()
    {
        if($this->content instanceof Component)
        {
            if(method_exists($this->content, 'render'))
            {
                return $this->content->render();
            }
            return null;
        }else{
            return $this->content;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}