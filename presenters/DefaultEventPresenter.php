<?php

declare(strict_types=1);

namespace app\presenters;

class DefaultEventPresenter extends BaseEventWidgetPresenter
{
    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'username' => $this->getUsername(),
            'body' => $this->getBody(),
            'bodyDatetime' => $this->getDateTime(),
            'iconType' => $this->getIconClass()
        ];
    }
}
