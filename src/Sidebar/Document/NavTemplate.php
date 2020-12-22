<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Sidebar\Document;


class NavTemplate extends BaseTemplate
{
    protected ?string $elementName='nav';
    public string $defaultClass='sidebar';

    /** @var string Bootstrap width grid class */
    public string $width='col-md-2';

    /** @var string|null Show from width [null = visible always, xs, sm, md, lg, xl] */
    public ?string $displayFromWidth='md';

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
            $this->addClass(sprintf('d-%s-block', $this->displayFromWidth));
        }
    }

    /**
     * Set width (ex. cols-sm-3 ...)
     * @param string $width
     */
    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    /**
     * Set display from width expecting parameters [null, xs, sm, md, lg, xl]
     * @param string|null $displayFromWidth
     */
    public function setDisplayFromWidth(?string $displayFromWidth): void
    {
        $this->displayFromWidth = $displayFromWidth;
    }

    /**
     * Set background class
     * @param string $background
     */
    public function setBackground(string $background): void
    {
        $this->background = $background;
    }


}