<?php

declare(strict_types=1);

namespace app\components\StreamExport\factories;

use app\components\StreamExport\models\Column;
use app\components\StreamExport\models\ColumnsConfig;
use app\widgets\Export\interfaces\ExportPresenterInterface;
use RuntimeException;
use Yii;

class ColumnsConfigFactory
{
    /** @var string */
    public const TYPE_DEFAULT = 'default';

    /**
     * @param string $type
     *
     * @return ColumnsConfig
     */
    public function create(string $type = self::TYPE_DEFAULT): ColumnsConfig
    {
        switch ($type) {
            case static::TYPE_DEFAULT:
                return $this->generateDefaultConfig();

            default:
                throw new RuntimeException('Unknown column config type: ' . $type);
        }
    }

    /**
     * @return ColumnsConfig
     */
    private function generateDefaultConfig(): ColumnsConfig
    {
        $dateColumn = new Column(
            Yii::t('app', 'Date'),
            static function (ExportPresenterInterface $presenter) {
                return $presenter->getDatetime();
            },
            'datetime'
        );

        $userColumn = new Column(
            Yii::t('app', 'User'),
            static function (ExportPresenterInterface $presenter) {
                return !empty($presenter->getUsername()) ? $presenter->getUsername() : Yii::t('app', 'System');
            }
        );

        $typeColumn = new Column(
            Yii::t('app', 'Type'),
            static function (ExportPresenterInterface $presenter) {
                return $presenter->getObjectType();
            }
        );

        $eventColumn = new Column(
            Yii::t('app', 'Event'),
            static function (ExportPresenterInterface $presenter) {
                return $presenter->getEventText();
            }
        );

        $messageColumn = new Column(
            Yii::t('app', 'Message'),
            static function (ExportPresenterInterface $presenter) {
                return $presenter->getMessage();
            }
        );

        return new ColumnsConfig([$dateColumn, $userColumn, $typeColumn, $eventColumn, $messageColumn]);
    }
}
