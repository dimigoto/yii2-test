<?php

declare(strict_types=1);

namespace app\components\StreamExport\factories;

use app\components\StreamExport\strategies\CsvStrategy;
use app\components\StreamExport\StreamExport;
use yii\data\DataProviderInterface;
use yii\i18n\Formatter;

class StreamExportFactory
{
    private const TYPE_CSV = 'CSV';

    private $dataProvider;
    private $filename;
    private $batchSize;
    private $fileType;
    private $columnsConfigType;
    private $formatter;

    public function __construct(
        DataProviderInterface $dataProvider,
        Formatter $formatter,
        string $filename,
        string $batchSize,
        string $fileType = self::TYPE_CSV,
        string $columnsConfigType = ColumnsConfigFactory::TYPE_DEFAULT
    ) {
        $this->formatter = $formatter;
        $this->dataProvider = $dataProvider;
        $this->filename = $filename;
        $this->batchSize = $batchSize;
        $this->fileType = $fileType;
        $this->columnsConfigType = $columnsConfigType;
    }

    /**
     * @return StreamExport
     */
    public function create(): StreamExport
    {
        switch ($this->fileType) {
            case static::TYPE_CSV:
                $exportStrategy = new CsvStrategy($this->filename);
                break;

            default:
                $exportStrategy = new CsvStrategy($this->filename);
        }

        $columnsConfigFactory = new ColumnsConfigFactory();
        $columnsConfig = $columnsConfigFactory->create($this->columnsConfigType);

        return new StreamExport(
            [
                'dataProvider' => $this->dataProvider,
                'formatter' => $this->formatter,
                'exportStrategy' => $exportStrategy,
                'batchSize' => $this->batchSize,
                'columnsConfig' => $columnsConfig
            ]
        );
    }
}
