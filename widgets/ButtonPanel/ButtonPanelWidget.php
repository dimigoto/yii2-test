<?php

declare(strict_types=1);

namespace app\widgets\ButtonPanel;

use yii\base\Widget;
use yii\helpers\Html;

class ButtonPanelWidget extends Widget
{
    /** @var bool */
    public $showExportButton;

    /** @var string */
    public $exportButtonText;

    /** @var string */
    public $exportButtonUrl;

    /** @var bool */
    public $showStreamExportButton;

    /** @var string */
    public $streamExportButtonText;

    /** @var string */
    public $streamExportButtonUrl;

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        $result = '';

        if ($this->showExportButton) {
            $result .= $this->renderExportButton();
        }

        if ($this->showStreamExportButton) {
            $result .= $this->renderStreamExportButton();
        }

        return $this->render('main', ['buttons' => $result]);
    }

    /**
     * Returns string of rendered export button template
     *
     * @return string
     */
    private function renderExportButton(): string
    {
        return Html::a(
            $this->exportButtonText,
            $this->exportButtonUrl,
            [
                'class' => 'btn btn-success',
                'data-pjax' => 0
            ]
        );
    }

    /**
     * Returns string of rendered stream export button template
     *
     * @return string
     */
    private function renderStreamExportButton(): string
    {
        return Html::a(
            $this->streamExportButtonText,
            $this->streamExportButtonUrl,
            [
                'class' => 'btn btn-success',
                'data-pjax' => 0
            ]
        );
    }
}
