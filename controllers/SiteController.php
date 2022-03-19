<?php

namespace app\controllers;

use app\factories\EventPresenterFactory;
use app\models\search\HistorySearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    private $historySearch;

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ]
        ];
    }

    /**
     * @param $action
     *
     * @return bool
     *
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->historySearch = new HistorySearch(
            [
                'eventPresenterFactory' => new EventPresenterFactory()
            ]
        );

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', ['model' => $this->historySearch]);
    }


    /**
     * @param string $exportType
     *
     * @return string
     */
    public function actionExport(string $exportType): string
    {
        return $this->render('export', [
            'dataProvider' => $this->historySearch->search(Yii::$app->request->queryParams),
            'exportType' => $exportType,
        ]);
    }
}
