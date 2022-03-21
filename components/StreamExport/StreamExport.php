<?php

declare(strict_types=1);

namespace app\components\StreamExport;

use app\components\StreamExport\interfaces\ExportStrategyInterface;
use app\components\StreamExport\models\ColumnsConfig;
use app\widgets\Export\interfaces\ExportPresenterInterface;
use Generator;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\i18n\Formatter;

class StreamExport extends Component
{
    /** @var ActiveDataProvider */
    public $dataProvider;

    /** @var ExportStrategyInterface */
    public $exportStrategy;

    /** @var int */
    public $batchSize;

    /** @var ColumnsConfig */
    public $columnsConfig;

    /** @var Formatter */
    public $formatter;

    public function __construct($config = [])
    {
        parent::__construct($config);

        if ($config['dataProvider'] !== null) {
            $this->dataProvider = clone $config['dataProvider'];
        }
    }

    /**
     * @return void
     */
    public function export(): void
    {
        $pagination = new Pagination(['pageSize' => $this->batchSize]);
        $this->dataProvider->setPagination($pagination);
        $this->exportStrategy->prepare();
        $this->exportStrategy->saveHeader($this->getColumnsLabels());

        $rows = $this->getNextRows();

        while ($rows->current() !== null) {
            foreach ($rows as $row) {
                $this->exportStrategy->saveRow($row);
            }

            $this->incrementCurrentPage();
            $rows = $this->getNextRows();
        }

        $this->exportStrategy->cleanUp();
    }

    /**
     * @return array
     */
    private function getColumnsLabels(): array
    {
        $result = [];

        foreach ($this->columnsConfig->getColumns() as $column) {
            $result[] = $column->getLabel() ?? '';
        }

        return $result;
    }

    /**
     * @return Generator
     */
    private function getNextRows(): Generator
    {
        foreach ($this->dataProvider->getModels() as $model) {
            yield $this->modelToPresenter($model);
        }
    }

    /**
     * @param ExportPresenterInterface $model
     *
     * @return array
     */
    private function modelToPresenter(ExportPresenterInterface $model): array
    {
        return array_map(function ($column) use ($model) {
            if ($this->formatter !== null && !empty($column->getFormat())) {
                return $this->formatter->format($column->getValue()($model), $column->getFormat());
            }

            return $column->getValue()($model);
        }, $this->columnsConfig->getColumns());
    }

    /**
     * @return void
     */
    private function incrementCurrentPage(): void
    {
        $page = $this->dataProvider->pagination->getPage() + 1;
        $this->dataProvider->pagination->setPage($page);
        $this->dataProvider->refresh();
    }
}
