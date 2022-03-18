<?php

use app\widgets\ButtonPanel\ButtonPanelWidget;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $exportButtonUrl string */
/* @var $exportButtonText string */

?>

<?php Pjax::begin(['id' => 'grid-pjax', 'formSelector' => false]); ?>

<?= ButtonPanelWidget::widget(
    [
        'showExportButton' => true,
        'exportButtonUrl' => $exportButtonUrl,
        'exportButtonText' => $exportButtonText
    ]
) ?>

<?= ListView::widget(
    [
        'dataProvider' => $dataProvider,
        'itemView' => '_event',
        'options' => [
            'tag' => 'ul',
            'class' => 'list-group'
        ],
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'list-group-item'
        ],
        'emptyTextOptions' => ['class' => 'empty p-20'],
        'layout' => '{items}{pager}',
    ]
); ?>

<?php Pjax::end(); ?>
