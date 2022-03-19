<?php

declare(strict_types=1);

namespace app\models\presenters;

use app\models\Fax;
use app\models\History;
use app\widgets\EventWidget\BaseEventWidget;
use Yii;

class FaxEventPresenter extends BaseEventWidgetPresenter
{
    /** @var Fax */
    private $fax;

    public function __construct(History $event)
    {
        parent::__construct($event);

        $this->fax = $this->event->fax;
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
            'footerDatetime' => $this->getDatetime(),
        ];
    }

    /**
     * @return string
     */
    public function getFooter(): string
    {
        return Yii::t('app', '{type} was sent', [
            'type' => $this->fax
                ? $this->fax->getTypeText()
                : Yii::t('app', 'Fax')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getIconClass(): string
    {
        return BaseEventWidget::ICON_FAX;
    }
}
