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
     * @return string
     */
    public function run(): string
    {
        return $this->render('main', [
            'exportButtonUrl' => $this->getExportButtonUrl(),
            'exportButtonText' => Yii::t('app', 'CSV'),
            'dataProvider' => $this->model->search(Yii::$app->request->queryParams)
        ]);
    }

    /**
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
