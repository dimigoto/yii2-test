<?php

declare(strict_types=1);

namespace app\widgets\HistoryList\interfaces;

interface EventWidgetPresenterInterface
{
    /**
     * Return array with params for widget
     *
     * @return array
     */
    public function widgetParams(): array;

    /**
     * Returns event type
     *
     * @return string
     */
    public function getEventType(): string;
}
