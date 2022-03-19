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
     * @inheritdoc
     *
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
     * Returns true whether to render icon
     *
     * @return bool
     */
    protected function needRenderIcon(): bool
    {
        return !empty($this->iconType);
    }

    /**
     * Returns string with rendered icon template
     *
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
     * Returns css classes of icons
     *
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
     * Returns true whether to render body
     *
     * @return bool
     */
    protected function needRenderBody(): bool
    {
        return !empty($this->body) || !empty($this->bodyDatetime);
    }

    /**
     * Returns string with rendered body template
     *
     * @return string
     *
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
     * Returns true whether to render username
     *
     * @return bool
     */
    protected function needRenderUsername(): bool
    {
        return !empty($this->username);
    }

    /**
     * Returns string with rendered username template
     *
     * @return string
     */
    protected function renderUsername(): string
    {
        return Html::tag('div', $this->username, ['class' => 'bg-info']);
    }

    /**
     * Returns true whether to render content
     *
     * @return bool
     */
    protected function needRenderContent(): bool
    {
        return !empty($this->content);
    }

    /**
     * Returns string with rendered content template
     *
     * @return string
     */
    protected function renderContent(): string
    {
        return Html::tag('div', $this->content, ['class' => 'bg-info']);
    }

    /**
     * Returns true whether to render footer
     *
     * @return bool
     */
    protected function needRenderFooter(): bool
    {
        return !empty($this->footer) || !empty($this->footerDatetime);
    }

    /**
     * Returns string with rendered footer template
     *
     * @return string
     *
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
