<?php

declare(strict_types=1);

namespace app\widgets\ButtonPanel;

use yii\base\Widget;
use yii\helpers\Html;

class ButtonPanelWidget extends Widget
{
    public $showExportButton;
    public $exportButtonText;
    public $exportButtonUrl;

    public function run(): string
    {
        $result = '';

        if ($this->showExportButton) {
            $result .= $this->renderExportButton();
        }

        return $this->render('main', ['buttons' => $result]);
    }

    /**
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
}
