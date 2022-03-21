<?php

declare(strict_types=1);

namespace app\components\StreamExport\interfaces;

interface ExportStrategyInterface
{
    /**
     * @return void
     */
    public function prepare(): void;

    /**
     * @param array $values
     *
     * @return void
     */
    public function saveHeader(array $values): void;

    /**
     * @param array $values
     *
     * @return void
     */
    public function saveRow(array $values): void;

    /**
     * @return void
     */
    public function cleanUp(): void;
}
