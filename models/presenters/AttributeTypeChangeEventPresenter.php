<?php

declare(strict_types=1);

namespace app\models\presenters;

class AttributeTypeChangeEventPresenter extends BaseAttributeChangeEventPresenter
{
    /**
     * @inheritdoc
     */
    protected function getAttribute(): string
    {
        return 'type';
    }
}
