<?php

declare(strict_types=1);

namespace app\widgets\Export\interfaces;

interface ExportPresenterInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getDatetime(): string;

    /**
     * @return string
     */
    public function getObjectType(): string;

    /**
     * @return string
     */
    public function getEventText(): string;

    /**
     * @return string
     */
    public function getMessage(): string;
}
