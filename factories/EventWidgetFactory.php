<?php

declare(strict_types=1);

namespace app\factories;

use app\models\History;
use app\widgets\EventWidget\AttributeChangeEventWidget;
use app\widgets\EventWidget\BaseEventWidget;
use app\widgets\EventWidget\CallEventWidget;
use app\widgets\HistoryList\interfaces\EventWidgetPresenterInterface;
use yii\base\Widget;

class EventWidgetFactory
{
    /**
     * Map of event type to event widget class. Could be move to config
     */
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

    /** @var EventWidgetPresenterInterface */
    private $eventPresenter;

    /** @var string[] */
    private $eventMap;

    public function __construct(EventWidgetPresenterInterface $eventPresenter, array $eventMap = [])
    {
        $this->eventPresenter = $eventPresenter;
        $this->eventMap = ($eventMap === []) ? static::EVENTS_MAP : $eventMap;
    }

    /**
     * Creates widget
     *
     * @param string $eventType
     *
     * @return Widget
     */
    public function create(string $eventType): Widget
    {
        $widgetClass = $this->getWidgetClassByEventType($eventType);

        return $widgetClass !== null
            ? new $widgetClass($this->eventPresenter->widgetParams())
            : new BaseEventWidget($this->eventPresenter->widgetParams());
    }

    /**
     * Returns widget classname by event type. Null if widget class have not register
     *
     * @param string $eventType
     *
     * @return string|null
     */
    private function getWidgetClassByEventType(string $eventType): ?string
    {
        return $this->eventMap[$eventType] ?? null;
    }
}
