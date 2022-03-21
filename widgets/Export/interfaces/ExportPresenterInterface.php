<?php

declare(strict_types=1);

namespace app\widgets\Export\interfaces;

interface ExportPresenterInterface
{
    /**
     * Returns username
     *
     * @return string
     */
    public function getUsername(): string;

    /**
     * Returns date and time
     *
     * @return string
     */
    public function getDatetime(): string;

    /**
     * Returns object type
     *
     * @return string
     */
    public function getObjectType(): string;

    /**
     * Returns event text
     *
     * @return string
     */
    public function getEventText(): string;

    /**
     * Returns message
     *
     * @return string
     */
    public function getMessage(): string;
}
