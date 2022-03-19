<?php

declare(strict_types=1);

namespace app\decorators;

use app\factories\EventPresenterFactory;
use yii\base\Component;
use yii\base\UnknownMethodException;
use yii\data\BaseDataProvider;
use yii\data\DataProviderInterface;

class PresenterDataProviderDecorator extends Component implements DataProviderInterface
{
    /** @var BaseDataProvider */
    public $dataProvider;

    /** @var EventPresenterFactory */
    public $eventPresenterFactory;

    /**
     * @inheritdoc
     */
    public function getModels(): array
    {
        $result = [];

        foreach ($this->dataProvider->getModels() as $model) {
            $result[] = $this->eventPresenterFactory->create($model);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function prepare($forcePrepare = false): void
    {
        $this->dataProvider->prepare($forcePrepare);
    }

    /**
     * @inheritdoc
     */
    public function getCount(): int
    {
        return $this->dataProvider->getCount();
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount(): int
    {
        return $this->dataProvider->getTotalCount();
    }

    /**
     * @inheritdoc
     */
    public function getKeys(): array
    {
        return $this->dataProvider->getKeys();
    }

    /**
     * @inheritdoc
     */
    public function getSort()
    {
        return $this->dataProvider->getSort();
    }

    /**
     * @inheritdoc
     */
    public function getPagination()
    {
        return $this->dataProvider->getPagination();
    }

    /**
     * @param $value
     *
     * @return void
     */
    public function setPagination($value): void
    {
        $this->dataProvider->setPagination($value);
    }

    /**
     * If method not found, try to call decorated object method
     *
     * @inheritdoc
     */
    public function __call($name, $params)
    {
        if (method_exists($this->dataProvider, $name)) {
            return call_user_func_array(array($this->dataProvider, $name), $params);
        }

        throw new UnknownMethodException(
            'Undefined method - ' . get_class($this->dataProvider) . '::' . $name
        );
    }

    /**
     * If property not found, try to get decorated object property
     *
     * @inheritdoc
     */
    public function __get($name)
    {
        if (property_exists($this->dataProvider, $name)) {
            return $this->dataProvider->$name;
        }

        return parent::__get($name);
    }

    /**
     * If property not found, try to set decorated object property
     *
     * @inheritdoc
     */
    public function __set($name, $value): void
    {
        if (property_exists($this->dataProvider, $name)) {
            $this->dataProvider->$name = $value;
        }

        parent::__set($name, $value);
    }
}
