<?php

declare(strict_types=1);

namespace app\models\presenters;

use Yii;

abstract class BaseAttributeChangeEventPresenter extends BaseEventWidgetPresenter
{
    private const MESSAGES_PREFIX = 'attribute';

    /**
     * @return string
     */
    abstract protected function getAttribute(): string;

    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'body' => $this->getBody(),
            'username' => $this->getUsername(),
            'bodyDatetime' => $this->getDatetime(),
            'oldValue' => $this->getOldValue(),
            'newValue' => $this->getNewValue()
        ];
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        $content = [];

        if (!empty($this->getBody())) {
            $content[] = $this->getBody();
        }

        $content[] = implode(
            ' ',
            [
                $this->getOldValue(),
                '&#8594;',
                $this->getNewValue(),
            ]
        );

        if (!empty($this->getDatetime())) {
            $content[] = $this->getDatetime();
        }

        return implode(' ', $content);
    }

    /**
     * @return string
     */
    protected function getOldValue(): string
    {
        $oldValue = $this->event->getDetailOldValue($this->getAttribute());

        if (empty($oldValue)) {
            return Yii::t('app', sprintf('%s.%s', self::MESSAGES_PREFIX, 'not_set'));
        }

        return Yii::t(
            'app',
            sprintf('%s.%s.%s', self::MESSAGES_PREFIX, $this->getAttribute(), $oldValue)
        );
    }

    /**
     * @return string
     */
    protected function getNewValue(): string
    {
        $newValue = $this->event->getDetailNewValue($this->getAttribute());

        if (empty($newValue)) {
            return Yii::t('app', sprintf('%s.%s', self::MESSAGES_PREFIX, 'not_set'));
        }

        return Yii::t(
            'app',
            sprintf('%s.%s.%s', self::MESSAGES_PREFIX, $this->getAttribute(), $newValue)
        );
    }
}
