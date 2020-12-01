<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


class PreviousLinkTemplate extends BaseLinkTemplate
{
    public function beforeRender(): void
    {
        parent::beforeRender();
        $paginator = $this->pagination->getPaginator();
        $previousPage = $paginator->page-1 > 0 ? $paginator->page-1 : 1;

        $this->setLink($this->pagination->link('paginate!', $previousPage));
        $this->addHtmlAttribute('aria-label', 'Previous');
        $this->addSpanElement(null, ['aria-hidden'=>'true'])
            ->setText(' < ');
        $this->addSpanElement('sr-only')
            ->setText('Previous');
    }
}