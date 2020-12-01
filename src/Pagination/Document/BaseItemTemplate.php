<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


use e2221\BootstrapComponents\Pagination\Pagination;
use e2221\utils\Html\BaseElement;

class BaseItemTemplate extends BaseElement
{
    protected Pagination $pagination;

    protected ?string $elementName = 'li';
    public string $defaultClass='page-item';

    public function __construct(Pagination $pagination)
    {
        parent::__construct();
        $this->pagination = $pagination;
    }

    /**
     * Set item active
     * @return BaseItemTemplate
     */
    public function setActive(): self
    {
        $this->setClass('active');
        return $this;
    }

    /**
     * Set item disabled
     * @return BaseItemTemplate
     */
    public function setDisabled(): self
    {
        $this->setClass('disabled');
        return $this;
    }
}