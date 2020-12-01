<?php
declare(strict_types=1);

namespace e2221\BootstrapComponents\Pagination\Document;


class FirstLinkTemplate extends BaseLinkTemplate
{
    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->setLink($this->pagination->link('paginate!', 1));
        $this->addHtmlAttribute('aria-label', 'First');
        $this->addSpanElement(null, ['aria-hidden'=>'true'])
            ->setText(' << ');
        $this->addSpanElement('sr-only')
            ->setText('First');
    }
}