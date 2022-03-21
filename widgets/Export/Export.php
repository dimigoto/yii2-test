<?php

namespace app\widgets\Export;

use kartik\export\ExportMenu;
use Yii;

class Export extends ExportMenu
{
    private const EXPORT_REQUEST_PARAMS_PREFIX = 'exportFull_';

    public $exportType = self::FORMAT_CSV;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (empty($this->exportRequestParam)) {
            $this->exportRequestParam = static::EXPORT_REQUEST_PARAMS_PREFIX . $this->options['id'];
        }

        Yii::$app->request->setBodyParams(
            [
                Yii::$app->request->methodParam => 'POST',
                $this->exportRequestParam => true,
                $this->exportTypeParam => $this->exportType,
                $this->colSelFlagParam => false
            ]
        );

        parent::init();
    }
}
