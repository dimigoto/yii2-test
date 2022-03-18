<?php

declare(strict_types=1);

namespace app\presenters;

use app\models\History;
use app\models\Sms;
use app\widgets\EventWidget\BaseEventWidget;
use Yii;

class SmsEventPresenter extends BaseEventWidgetPresenter
{
    /** @var Sms */
    private $sms;

    public function __construct(History $event)
    {
        parent::__construct($event);

        $this->sms = $this->event->sms;
    }

    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'iconType' => $this->getIconClass(),
            'username' => $this->getUsername(),
            'body' => $this->getBody(),
            'footer' => $this->getFooter(),
            'footerDatetime' => $this->getDateTime(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getBody(): string
    {
        return $this->sms->message ?? '';
    }

    /**
     * @return string
     */
    public function getFooter(): string
    {
        return $this->sms->isIncoming()
            ? Yii::t(
                'app',
                'Incoming message from {number}',
                [
                    'number' => $this->sms->getSenderPhone()
                ]
            )
            : Yii::t(
                'app',
                'Sent message to {number}',
                [
                    'number' => $this->sms->getReceiverPhone()
                ]
            );
    }

    /**
     * @inheritdoc
     */
    public function getIconClass(): string
    {
        return BaseEventWidget::ICON_SMS;
    }
}
