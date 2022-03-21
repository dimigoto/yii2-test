<?php

declare(strict_types=1);

namespace app\components\StreamExport\models;

class ColumnsConfig
{
    /** @var Column[]  */
    private $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
