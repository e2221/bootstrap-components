<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


class NextLinkTemplate extends BaseLinkTemplate
{
    public function beforeRender(): void
    {
        parent::beforeRender();
        $paginator = $this->pagination->getPaginator();
        $nextPage = $paginator->page+1 > $paginator->getPageCount() ?  $paginator->getPageCount() : $paginator->page+1;

        $this->setLink($this->pagination->link('paginate!', $nextPage));
        $this->addHtmlAttribute('aria-label', 'Next');
        $this->addSpanElement(null, ['aria-hidden'=>'true'])
            ->setText(' > ');
        $this->addSpanElement('sr-only')
            ->setText('Next');
    }
}