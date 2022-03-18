<?php

declare(strict_types=1);

namespace app\presenters;

use Yii;

class AttributeQualityChangeEventPresenter extends BaseEventWidgetPresenter
{
    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'body' => $this->getBody(),
            'username' => $this->getUsername(),
            'bodyDatetime' => $this->getDateTime(),
            'oldValue' => $this->getOldValue(),
            'newValue' => $this->getNewValue()
        ];
    }

    /**
     * @return string
     */
    private function getOldValue(): string
    {
        $oldValue = $this->event->getDetailOldValue('quality');

        return Yii::t('attribute_quality', $oldValue);
    }

    /**
     * @return string
     */
    private function getNewValue(): string
    {
        $newValue = $this->event->getDetailNewValue('quality');

        return Yii::t('attribute_quality', $newValue);
    }
}
