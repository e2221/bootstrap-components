<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components;

use e2221\BootstrapComponents\Modal\Modal;

class ModalMainTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='modal';
    public string $animation='fade';
    private Modal $modal;

    public function __construct(Modal $modal)
    {
        parent::__construct();
        $this->modal = $modal;
    }

    public function beforeRender(): void
    {
        $this
            ->addHtmlAttribute('tabindex', '-1')
            ->addHtmlAttribute('aria-hidden', 'true')
            ->addHtmlAttribute('id', $this->modal->getModalId());
        $this->addClass($this->animation);
        parent::beforeRender();
    }

    /**
     * Set Animation
     * @param string $animation
     * @return ModalMainTemplate
     */
    public function setAnimation(string $animation): self
    {
        $this->animation = $animation;
        return $this;
    }

    /**
     * Set static backdrop
     * @param bool $static
     * @return ModalMainTemplate
     */
    public function setStaticBackdrop(bool $static=true): self
    {
        if($static === true)
            $this
                ->addDataAttribute('backdrop', 'static')
                ->addDataAttribute('keyboard', 'false');
        return $this;
    }

    /**
     * Set modal id
     * @param string $id
     * @return ModalMainTemplate
     */
    public function setModalId(string $id): self
    {
        $this->addHtmlAttribute('id', $id);
        return $this;
    }
}