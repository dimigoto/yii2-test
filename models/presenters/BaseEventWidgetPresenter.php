<?php

declare(strict_types=1);

namespace app\models\presenters;

use app\models\History;
use app\widgets\EventWidget\BaseEventWidget;
use app\widgets\Export\interfaces\ExportPresenterInterface;
use app\widgets\HistoryList\interfaces\EventWidgetPresenterInterface;

abstract class BaseEventWidgetPresenter implements EventWidgetPresenterInterface, ExportPresenterInterface
{
    /** @var History */
    protected $event;

    public function __construct(History $event)
    {
        $this->event = $event;
    }

    /**
     * @inheritdoc
     */
    public function getEventType(): string
    {
        return $this->event->event;
    }

    /**
     * @inheritdoc
     */
    public function getUsername(): string
    {
        return $this->event->user->username ?? '';
    }

    /**
     * @inheritdoc
     */
    public function getDatetime(): string
    {
        return $this->event->ins_ts;
    }

    /**
     * @inheritdoc
     */
    public function getObjectType(): string
    {
        return $this->event->object;
    }

    /**
     * @inheritdoc
     */
    public function getEventText(): string
    {
        return $this->event->eventText;
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        return $this->getBody();
    }

    /**
     * Returns icon css classes
     *
     * @return string
     */
    protected function getIconClass(): string
    {
        return BaseEventWidget::ICON_DEFAULT;
    }

    /**
     * Returns body text
     *
     * @return string
     */
    protected function getBody(): string
    {
        return $this->event->eventText;
    }
}
