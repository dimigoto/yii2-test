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
     * @inheritdoc
     */
    public function getMessage(): string
    {
        if ($this->isCallDeleted()) {
            return Yii::t('app', 'Deleted');
        }

        return implode(' ', [$this->getTotalStatusText(), $this->getTotalDisposition()]);
    }

    /**
     * Returns content text
     *
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
     * Returns true whether call is null
     *
     * @return bool
     */
    private function isCallDeleted(): bool
    {
        return $this->call === null;
    }

    /**
     * Returns true whether call has been answered
     *
     * @return bool
     */
    private function isAnswered(): bool
    {
        return !$this->isCallDeleted() && $this->call->isClientAnswer();
    }

    /**
     * Returns call total disposition
     *
     * @return string
     */
    private function getTotalDisposition(): string
    {
        return $this->call ? $this->call->getTotalDisposition(false) : '';
    }

    /**
     * Returns call total status text
     *
     * @return string
     */
    private function getTotalStatusText(): string
    {
        return $this->call->totalStatusText ?? '';
    }
}
