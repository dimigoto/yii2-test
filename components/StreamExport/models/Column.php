<?php

declare(strict_types=1);

namespace app\components\StreamExport\models;

class Column
{
    private $label;
    private $format;
    private $value;

    public function __construct(string $label, $value, ?string $format = null)
    {
        $this->label = $label;
        $this->value = $value;
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return callable
     */
    public function getValue(): callable
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }
}
