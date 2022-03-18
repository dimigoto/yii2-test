<?php

declare(strict_types=1);

namespace app\widgets\EventWidget;

use app\widgets\DateTime\DateTime;
use Exception;
use yii\base\Widget;
use yii\helpers\Html;

class BaseEventWidget extends Widget
{
    public const ICON_DEFAULT = 'default';
    public const ICON_CHECK = 'check';
    public const ICON_SMS = 'sms';
    public const ICON_FAX = 'fax';
    public const ICON_CALL = 'call';
    public const ICON_CALL_MISSED = 'missed';

    public $iconType;
    public $body;
    public $bodyDatetime;
    public $username;
    public $content;
    public $footer;
    public $footerDatetime;

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        $result = $this->needRenderIcon() ? $this->renderIcon() : '';
        $result .= $this->needRenderBody() ? $this->renderBody() : '';
        $result .= $this->needRenderUsername() ? $this->renderUsername() : '';
        $result .= $this->needRenderContent() ? $this->renderContent() : '';
        $result .= $this->needRenderFooter() ? $this->renderFooter() : '';

        return $result;
    }

    /**
     * @return bool
     */
    protected function needRenderIcon(): bool
    {
        return !empty($this->iconType);
    }

    /**
     * @return string
     */
    protected function renderIcon(): string
    {
        return Html::tag(
            'i',
            '',
            [
                'class' => "icon icon-circle icon-main white " . $this->getIconClass()
            ]
        );
    }

    /**
     * @return string
     */
    protected function getIconClass(): string
    {
        switch ($this->iconType) {
            case static::ICON_CHECK:
                return 'fa-check-square bg-yellow';

            case static::ICON_SMS:
                return 'icon-sms bg-dark-blue';

            case static::ICON_FAX:
                return 'fa-fax bg-green';

            case static::ICON_CALL:
                return 'md-phone bg-green';

            case static::ICON_CALL_MISSED:
                return 'md-phone-missed bg-red';

            default:
                return 'fa-gear bg-purple-light';
        }
    }

    /**
     * @return bool
     */
    protected function needRenderBody(): bool
    {
        return !empty($this->body) || !empty($this->bodyDatetime);
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function renderBody(): string
    {
        $content = '';

        if (!empty($this->body)) {
            $content .= $this->body;
        }

        if (!empty($this->bodyDatetime)) {
            $content .= DateTime::widget(['dateTime' => $this->bodyDatetime]);
        }

        return Html::tag(
            'div',
            $content,
            ['class' => 'bg-success']
        );
    }

    /**
     * @return bool
     */
    protected function needRenderUsername(): bool
    {
        return !empty($this->username);
    }

    /**
     * @return string
     */
    protected function renderUsername(): string
    {
        return Html::tag('div', $this->username, ['class' => 'bg-info']);
    }

    /**
     * @return bool
     */
    protected function needRenderContent(): bool
    {
        return !empty($this->content);
    }

    /**
     * @return string
     */
    protected function renderContent(): string
    {
        return Html::tag('div', $this->content, ['class' => 'bg-info']);
    }

    /**
     * @return bool
     */
    protected function needRenderFooter(): bool
    {
        return !empty($this->footer) || !empty($this->footerDatetime);
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function renderFooter(): string
    {
        $content = [];

        if (!empty($this->footer)) {
            $content[] = $this->footer;
        }

        if (!empty($this->footerDatetime)) {
            $content[] = DateTime::widget(['dateTime' => $this->footerDatetime]);
        }

        return Html::tag(
            'div',
            implode(' ', $content),
            ['class' => 'bg-warning']
        );
    }
}
