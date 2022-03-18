<?php

use app\factories\EventPresenterFactory;
use app\factories\EventWidgetFactory;
use app\models\search\HistorySearch;

/** @var $model HistorySearch */

$widgetFactory = new EventWidgetFactory(new EventPresenterFactory());
$widget = $widgetFactory->create($model);

echo $widget->run();
