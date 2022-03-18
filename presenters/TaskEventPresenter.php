<?php

declare(strict_types=1);

namespace app\presenters;

use app\widgets\EventWidget\BaseEventWidget;

class TaskEventPresenter extends BaseEventWidgetPresenter
{
    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'iconType' => $this->getIconClass(),
            'username' => $this->getUsername(),
            'body' => $this->getBody(),
            'footer' => $this->getFooter(),
            'footerDatetime' => $this->getDateTime(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getBody(): string
    {
        return sprintf(
            '%s: %s',
            $this->event->eventText,
            $this->event->task->title ?? ''
        );
    }

    /**
     * @return string
     */
    public function getFooter(): string
    {
        return isset($this->event->task->customer->name)
            ? sprintf('Creditor: %s', $this->event->task->customer->name)
            : '';
    }

    /**
     * @inheritdoc
     */
    public function getIconClass(): string
    {
        return BaseEventWidget::ICON_CHECK;
    }
}
