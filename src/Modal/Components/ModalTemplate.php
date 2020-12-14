<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components;


use e2221\utils\Html\BaseElement;

class ModalTemplate extends BaseElement
{
    protected ?string $elementName='div';
    public string $defaultClass='modal';
    public string $animation='fade';

    public function beforeRender(): void
    {
        $this->addHtmlAttributes(['tabindex'=>'-1', 'aria-hidden', 'true']);
        $this->addClass($this->animation);
        parent::beforeRender();
    }

    /**
     * Set Animation
     * @param string $animation
     * @return ModalTemplate
     */
    public function setAnimation(string $animation): self
    {
        $this->animation = $animation;
        return $this;
    }

    /**
     * Set modal id
     * @param string $id
     * @return ModalTemplate
     */
    public function setModalId(string $id): self
    {
        $this->addHtmlAttribute('id', $id);
        return $this;
    }
}