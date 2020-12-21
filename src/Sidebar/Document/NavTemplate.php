<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document;


class NavTemplate extends BaseTemplate
{
    protected ?string $elementName='nav';
    public string $defaultClass='sidebar';

    /** @var string Bootstrap width grid class */
    public string $width='col-md-2';

    /** @var string|null Show from width bootstrap class [null = visible always] */
    public ?string $displayFromWidth='d-md-block';

    /** @var string Background class */
    public string $background='bg-light';

    public function beforeRender(): void
    {
        parent::beforeRender();
        $this
            ->addClass($this->width)
            ->addClass($this->background);
        if(is_string($this->displayFromWidth))
        {
            $this->addClass('d-none');
            $this->addClass($this->displayFromWidth);
        }
    }

    /**
     * @param string $width
     */
    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    /**
     * @param string|null $displayFromWidth
     */
    public function setDisplayFromWidth(?string $displayFromWidth): void
    {
        $this->displayFromWidth = $displayFromWidth;
    }

    /**
     * @param string $background
     */
    public function setBackground(string $background): void
    {
        $this->background = $background;
    }


}