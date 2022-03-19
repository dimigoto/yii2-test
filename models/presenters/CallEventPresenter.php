<?php

declare(strict_types=1);

namespace app\models\presenters;

use app\models\Call;
use app\models\History;
use app\widgets\EventWidget\BaseEventWidget;
use Yii;

class CallEventPresenter extends BaseEventWidgetPresenter
{
    /** @var Call */
    private $call;

    public function __construct(History $event)
    {
        parent::__construct($event);

        $this->call = $this->event->call;
    }

    /**
     * @inheritdoc
     */
    public function widgetParams(): array
    {
        return [
            'iconType' => $this->getIconClass(),
            'username' => $this->getUsername(),
            'content' => $this->getContent(),
            'totalStatusText' => $this->getTotalStatusText(),
            'totalDisposition' => $this->getTotalDisposition(),
            'isCallDeleted' => $this->isCallDeleted(),
            'footerDatetime' => $this->getDatetime(),
        ];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        if ($this->isCallDeleted()) {
            return Yii::t('app', 'Deleted');
        }

        return implode(' ', [$this->getTotalStatusText(), $this->getTotalDisposition()]);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->call ? $this->call->getComment() : '';
    }

    /**
     * @inheritdoc
     */
    public function getIconClass(): string
    {
        return !$this->isCallDeleted() && $this->isAnswered()
            ? BaseEventWidget::ICON_CALL
            : BaseEventWidget::ICON_CALL_MISSED;
    }

    /**
     * @return bool
     */
    private function isCallDeleted(): bool
    {
        return $this->call === null;
    }

    /**
     * @return bool
     */
    private function isAnswered(): bool
    {
        return !$this->isCallDeleted() && $this->call->isClientAnswer();
    }

    /**
     * @return string
     */
    private function getTotalDisposition(): string
    {
        return $this->call ? $this->call->getTotalDisposition(false) : '';
    }

    /**
     * @return string
     */
    private function getTotalStatusText(): string
    {
        return $this->call->totalStatusText ?? '';
    }
}
