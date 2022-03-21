<?php

declare(strict_types=1);

namespace app\components\StreamExport\strategies;

use app\components\StreamExport\interfaces\ExportStrategyInterface;

class CsvStrategy implements ExportStrategyInterface
{
    /** @var string */
    private $filename;

    /** @var string */
    private $separator;

    /** @var string */
    private $now;

    /** @var resource */
    private $stream;

    /**
     * @param string $filename
     * @param string $separator
     */
    public function __construct(string $filename, string $separator = ';')
    {
        $this->filename = $filename;
        $this->separator = $separator;
    }

    /**
     * @inheritdoc
     */
    public function prepare(): void
    {
        ob_start();
        $this->setHeaders();
        $this->stream = fopen('php://output', 'wb');
    }

    /**
     * @inheritdoc
     */
    public function saveHeader(array $values): void
    {
        $this->saveRow($values);
    }

    /**
     * @inheritdoc
     */
    public function saveRow(array $values): void
    {
        fputcsv($this->stream, $values, $this->separator);
    }

    /**
     * @inheritDoc
     */
    public function cleanUp(): void
    {
        ob_flush();
        flush();
        ob_end_clean();
    }

    /**
     * @return void
     */
    private function setHeaders(): void
    {
        header('Expires: Tue, 03 Jul 20017 12:00:00 GMT');
        header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
        header('Last-Modified: ' . $this->getNow() . ' GMT');

        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-type: text/csv');

        header('Content-Disposition: attachment;filename=' . $this->filename . '.csv');
        header('Content-Transfer-Encoding: binary');
    }

    /**
     * @return string
     */
    private function getNow(): string
    {
        if (empty($this->now)) {
            $this->now = gmdate("D, d M Y H:i:s");
        }

        return $this->now;
    }
}
