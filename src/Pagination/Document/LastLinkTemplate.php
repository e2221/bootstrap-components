<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


class LastLinkTemplate extends BaseLinkTemplate
{
    public function beforeRender(): void
    {
        parent::beforeRender();
        $paginator = $this->pagination->getPaginator();

        $this->setLink($this->pagination->link('paginate!', $paginator->getLastPage()));
        $this->addHtmlAttribute('aria-label', 'Last');
        $this->addSpanElement(null, ['aria-hidden'=>'true'])
            ->setText(' >> ');
        $this->addSpanElement('sr-only')
            ->setText('Last');
    }
}