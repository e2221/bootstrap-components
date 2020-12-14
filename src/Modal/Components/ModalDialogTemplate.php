<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Modal\Components;


class ModalDialogTemplate extends BaseTemplate
{
    protected ?string $elementName='div';
    public string $defaultClass='modal-dialog';

    /**
     * Set width class
     * @param string $widthClass
     * @return ModalDialogTemplate
     */
    public function setModalWidth(string $widthClass): self
    {
        $this->addClass($widthClass);
        return $this;
    }

    /**
     * Set scrolling long content (adds modal-dialog-scrollable class)
     * @param bool $scrollingLongContent
     * @return ModalDialogTemplate
     */
    public function setScrollingLongContent(bool $scrollingLongContent=true): self
    {
        if($scrollingLongContent === true)
            $this->addClass('modal-dialog-scrollable');
        return $this;
    }

    /**
     * Set vertically centered content
     * @param bool $verticallyCentered
     * @return ModalDialogTemplate
     */
    public function setVerticallyCentered(bool $verticallyCentered=true): self
    {
        if($verticallyCentered === true)
            $this->addClass('modal-dialog-centered');
        return $this;
    }
}