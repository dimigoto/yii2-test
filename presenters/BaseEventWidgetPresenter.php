<?php

declare(strict_types=1);

namespace app\presenters;

use app\models\History;
use app\widgets\EventWidget\BaseEventWidget;
use app\widgets\HistoryList\interfaces\EventWidgetPresenterInterface;

abstract class BaseEventWidgetPresenter implements EventWidgetPresenterInterface
{
    /** @var History */
    protected $event;

    public function __construct(History $event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    protected function getUsername(): string
    {
        return $this->event->user->username ?? '';
    }

    /**
     * @return string
     */
    protected function getDateTime(): string
    {
        return $this->event->ins_ts;
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        return BaseEventWidget::ICON_DEFAULT;
    }

    /**
     * @return string
     */
    protected function getBody(): string
    {
        return $this->event->eventText;
    }
}
