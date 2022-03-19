<?php

declare(strict_types=1);

namespace app\widgets\HistoryList\interfaces;

use app\models\History;

interface EventWidgetPresenterInterface
{
    /**
     * Return array with params for widget
     *
     * @return array
     */
    public function widgetParams(): array;

    /**
     * @return string
     */
    public function getEventType(): string;
}
