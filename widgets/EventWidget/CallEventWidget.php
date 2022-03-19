<?php

declare(strict_types=1);

namespace app\widgets\EventWidget;

use Exception;
use Yii;
use yii\helpers\Html;

class CallEventWidget extends BaseEventWidget
{
    /** @var bool */
    public $isCallDeleted;

    /** @var string */
    public $totalStatusText;

    /** @var string */
    public $totalDisposition;

    /**
     * @return bool
     */
    protected function needRenderBody(): bool
    {
        return true;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function renderBody(): string
    {
        if ($this->isCallDeleted) {
            $result = Html::tag('i', Yii::t('app', 'Deleted'));
        } else {
            $totalDisposition = !empty($this->totalDisposition)
                ? Html::tag('span', $this->totalDisposition, ['class' => 'text-grey'])
                : '';

            $result = implode(' ', [$this->totalStatusText, $totalDisposition]);
        }

        return Html::tag(
            'div',
            $result,
            ['class' => 'bg-success']
        );
    }
}
