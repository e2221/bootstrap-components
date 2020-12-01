<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


use e2221\BootstrapComponents\Pagination\Pagination;
use Nette\SmartObject;

class DocumentTemplate
{
    use SmartObject;
    
    protected PaginatorTemplate $paginatorTemplate;
    protected BaseItemTemplate $baseItemTemplate;
    protected BaseLinkTemplate $baseLinkTemplate;
    protected FirstLinkTemplate $firstLinkTemplate;
    protected NextLinkTemplate $nextLinkTemplate;
    protected PreviousLinkTemplate $previousLinkTemplate;
    protected LastLinkTemplate $lastLinkTemplate;

    public function __construct(Pagination $pagination)
    {
        $this->paginatorTemplate = new PaginatorTemplate();
        $this->baseItemTemplate = new BaseItemTemplate($pagination);
        $this->baseLinkTemplate = new BaseLinkTemplate($pagination);
        $this->firstLinkTemplate = new FirstLinkTemplate($pagination);
        $this->nextLinkTemplate = new NextLinkTemplate($pagination);
        $this->previousLinkTemplate = new PreviousLinkTemplate($pagination);
        $this->lastLinkTemplate = new LastLinkTemplate($pagination);
    }

    /**
     * @return PaginatorTemplate
     */
    public function getPaginatorTemplate(): PaginatorTemplate
    {
        return $this->paginatorTemplate;
    }

    /**
     * @return BaseItemTemplate
     */
    public function getBaseItemTemplate(): BaseItemTemplate
    {
        return $this->baseItemTemplate;
    }

    /**
     * @return BaseLinkTemplate
     */
    public function getBaseLinkTemplate(): BaseLinkTemplate
    {
        return $this->baseLinkTemplate;
    }

    /**
     * @return FirstLinkTemplate
     */
    public function getFirstLinkTemplate(): FirstLinkTemplate
    {
        return $this->firstLinkTemplate;
    }

    /**
     * @return NextLinkTemplate
     */
    public function getNextLinkTemplate(): NextLinkTemplate
    {
        return $this->nextLinkTemplate;
    }

    /**
     * @return PreviousLinkTemplate
     */
    public function getPreviousLinkTemplate(): PreviousLinkTemplate
    {
        return $this->previousLinkTemplate;
    }

    /**
     * @return LastLinkTemplate
     */
    public function getLastLinkTemplate(): LastLinkTemplate
    {
        return $this->lastLinkTemplate;
    }

    /**
     * @return PaginatorTemplate
     * @internal
     */
    public function getRendererPaginatorTemplate(): PaginatorTemplate
    {
        return clone $this->paginatorTemplate;
    }

    /**
     * @return BaseItemTemplate
     * @internal
     */
    public function getRendererBaseItemTemplate(): BaseItemTemplate
    {
        return clone $this->baseItemTemplate;
    }

    /**
     * @return BaseLinkTemplate
     * @internal
     */
    public function getRendererBaseLinkTemplate(): BaseLinkTemplate
    {
        return clone $this->baseLinkTemplate;
    }

    /**
     * @return FirstLinkTemplate
     * @internal
     */
    public function getRendererFirstLinkTemplate(): FirstLinkTemplate
    {
        return clone $this->firstLinkTemplate;
    }

    /**
     * @return NextLinkTemplate
     * @internal
     */
    public function getRendererNextLinkTemplate(): NextLinkTemplate
    {
        return clone $this->nextLinkTemplate;
    }

    /**
     * @return PreviousLinkTemplate
     * @internal
     */
    public function getRendererPreviousLinkTemplate(): PreviousLinkTemplate
    {
        return clone $this->previousLinkTemplate;
    }

    /**
     * @return LastLinkTemplate
     * @internal
     */
    public function getRendererLastLinkTemplate(): LastLinkTemplate
    {
        return clone $this->lastLinkTemplate;
    }
    
    
    

}