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

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        $result = '';

        if ($this->showExportButton) {
            $result .= $this->renderExportButton();
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
}
