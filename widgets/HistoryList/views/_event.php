<?php

use app\factories\EventPresenterFactory;
use app\factories\EventWidgetFactory;
use app\models\search\HistorySearch;
use app\widgets\HistoryList\interfaces\EventWidgetPresenterInterface;

/** @var $model EventWidgetPresenterInterface */

$widgetFactory = new EventWidgetFactory($model);
$widget = $widgetFactory->create($model->getEventType());

echo $widget->run();
