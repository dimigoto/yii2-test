<?php

/**
 * @var $this yii\web\View
 * @var $model \app\models\History
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $exportType string
 */

use app\widgets\Export\Export;
use app\widgets\Export\interfaces\ExportPresenterInterface;

$filename = 'history';
$filename .= '-' . time();

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>

<?= Export::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => Yii::t('app', 'Date'),
            'format' => 'datetime',
            'value' => static function (ExportPresenterInterface $presenter) {
                return $presenter->getDatetime();
            }

        ],
        [
            'label' => Yii::t('app', 'User'),
            'value' => static function (ExportPresenterInterface $presenter) {
                return !empty($presenter->getUsername()) ? $presenter->getUsername() : Yii::t('app', 'System');
            }
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'value' => static function (ExportPresenterInterface $presenter) {
                return $presenter->getObjectType();
            }
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'value' => static function (ExportPresenterInterface $presenter) {
                return $presenter->getEventText();
            }
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'value' => static function (ExportPresenterInterface $presenter) {
                return $presenter->getMessage();
            }
        ]
    ],
    'exportType' => $exportType,
    'batchSize' => 2000,
    'filename' => $filename
]);
