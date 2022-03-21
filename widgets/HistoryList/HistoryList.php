<?php

namespace app\widgets\HistoryList;

use app\models\search\HistorySearch;
use app\widgets\Export\Export;
use kartik\export\ExportMenu;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

class HistoryList extends Widget
{
    public $model;

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        return $this->render('main', [
            'exportButtonUrl' => $this->getExportButtonUrl(),
            'exportButtonText' => Yii::t('app', 'CSV'),
            'streamExportButtonText' => Yii::t('app', 'Stream CSV'),
            'streamExportButtonUrl' => Url::to(['/site/stream-export']),
            'dataProvider' => $this->model->search(Yii::$app->request->queryParams)
        ]);
    }

    /**
     * returns URL to export data in CSV
     *
     * @return string
     */
    private function getExportButtonUrl(): string
    {
        $params = Yii::$app->getRequest()->getQueryParams();
        $params = ArrayHelper::merge([
            'exportType' => ExportMenu::FORMAT_CSV
        ], $params);
        $params[0] = 'site/export';

        return Url::to($params);
    }
}
