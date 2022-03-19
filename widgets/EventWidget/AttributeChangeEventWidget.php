<?php

declare(strict_types=1);

namespace app\widgets\EventWidget;

use app\widgets\DateTime\DateTime;
use Exception;
use yii\helpers\Html;

class AttributeChangeEventWidget extends BaseEventWidget
{
    private const NOT_SET_VALUE = 'not set';

    /** @var string */
    public $oldValue;

    /** @var string */
    public $newValue;

    /**
     * @return bool
     */
    protected function needRenderBody(): bool
    {
        return true;
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    protected function renderBody(): string
    {
        $content = [];

        if (!empty($this->body)) {
            $content[] = $this->body;
        }

        $content[] = implode(
            ' ',
            [
                Html::tag(
                    'span',
                    $this->valueOrNotSet($this->oldValue),
                    ['class' => 'badge badge-pill badge-warning']
                ),
                '&#8594;',
                Html::tag(
                    'span',
                    $this->valueOrNotSet($this->newValue),
                    ['class' => 'badge badge-pill badge-warning']
                ),
            ]
        );

        if (!empty($this->bodyDatetime)) {
            $content[] = DateTime::widget(['dateTime' => $this->bodyDatetime]);
        }

        return Html::tag(
            'div',
            implode(' ', $content),
            ['class' => 'bg-success']
        );
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function valueOrNotSet(string $value): string
    {
        return ($value !== static::NOT_SET_VALUE) ? $value : Html::tag('i', $value);
    }
}
