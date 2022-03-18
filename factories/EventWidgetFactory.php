<?php

declare(strict_types=1);

namespace app\factories;

use app\models\History;
use app\widgets\EventWidget\AttributeChangeEventWidget;
use app\widgets\EventWidget\BaseEventWidget;
use app\widgets\EventWidget\CallEventWidget;
use yii\base\Widget;

class EventWidgetFactory
{
    private const EVENTS_MAP = [
        History::EVENT_CREATED_TASK => BaseEventWidget::class,
        History::EVENT_COMPLETED_TASK => BaseEventWidget::class,
        History::EVENT_UPDATED_TASK => BaseEventWidget::class,
        History::EVENT_INCOMING_SMS => BaseEventWidget::class,
        History::EVENT_OUTGOING_SMS => BaseEventWidget::class,
        History::EVENT_OUTGOING_FAX => BaseEventWidget::class,
        History::EVENT_INCOMING_FAX => BaseEventWidget::class,
        History::EVENT_CUSTOMER_CHANGE_TYPE => AttributeChangeEventWidget::class,
        History::EVENT_CUSTOMER_CHANGE_QUALITY => AttributeChangeEventWidget::class,
        History::EVENT_INCOMING_CALL => CallEventWidget::class,
        History::EVENT_OUTGOING_CALL => CallEventWidget::class,
    ];

    /** @var EventPresenterFactory */
    private $eventPresenterFactory;

    /** @var string[] */
    private $eventMap;

    public function __construct(EventPresenterFactory $eventPresenterFactory, array $eventMap = [])
    {
        $this->eventPresenterFactory = $eventPresenterFactory;
        $this->eventMap = ($eventMap === []) ? static::EVENTS_MAP : $eventMap;
    }

    /**
     * @param History $event
     *
     * @return Widget
     */
    public function create(History $event): Widget
    {
        $eventPresenter = $this->eventPresenterFactory->create($event);
        $widgetClass = $this->getWidgetClassByEventType($event->event);

        return $widgetClass !== null
            ? new $widgetClass($eventPresenter->widgetParams())
            : new BaseEventWidget($eventPresenter->widgetParams());
    }

    /**
     * @param string $eventType
     *
     * @return string|null
     */
    private function getWidgetClassByEventType(string $eventType): ?string
    {
        return $this->eventMap[$eventType] ?? null;
    }
}
