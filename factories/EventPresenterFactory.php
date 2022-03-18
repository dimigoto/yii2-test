<?php

declare(strict_types=1);

namespace app\factories;

use app\models\History;
use app\presenters\AttributeQualityChangeEventPresenter;
use app\presenters\AttributeTypeChangeEventPresenter;
use app\presenters\CallEventPresenter;
use app\presenters\DefaultEventPresenter;
use app\presenters\FaxEventPresenter;
use app\presenters\SmsEventPresenter;
use app\presenters\TaskEventPresenter;
use app\widgets\HistoryList\interfaces\EventWidgetPresenterInterface;

class EventPresenterFactory
{
    private const EVENTS_MAP = [
        History::EVENT_CREATED_TASK => TaskEventPresenter::class,
        History::EVENT_COMPLETED_TASK => TaskEventPresenter::class,
        History::EVENT_UPDATED_TASK => TaskEventPresenter::class,
        History::EVENT_INCOMING_SMS => SmsEventPresenter::class,
        History::EVENT_OUTGOING_SMS => SmsEventPresenter::class,
        History::EVENT_OUTGOING_FAX => FaxEventPresenter::class,
        History::EVENT_INCOMING_FAX => FaxEventPresenter::class,
        History::EVENT_CUSTOMER_CHANGE_TYPE => AttributeTypeChangeEventPresenter::class,
        History::EVENT_CUSTOMER_CHANGE_QUALITY => AttributeQualityChangeEventPresenter::class,
        History::EVENT_INCOMING_CALL => CallEventPresenter::class,
        History::EVENT_OUTGOING_CALL => CallEventPresenter::class,
    ];

    /** @var string[] */
    private $eventsMap;

    /**
     * @param array $eventsMap
     */
    public function __construct(array $eventsMap = [])
    {
        $this->eventsMap = $eventsMap === [] ? static::EVENTS_MAP : $eventsMap;
    }

    /**
     * @param History $event
     *
     * @return EventWidgetPresenterInterface
     */
    public function create(History $event): EventWidgetPresenterInterface
    {
        $presenterClass = $this->getPresenterClassByEventType($event->event);

        return $presenterClass !== null ? new $presenterClass($event) : new DefaultEventPresenter($event);
    }

    /**
     * @param string $type
     *
     * @return string|null
     */
    private function getPresenterClassByEventType(string $type): ?string
    {
        return $this->eventsMap[$type] ?? null;
    }
}
