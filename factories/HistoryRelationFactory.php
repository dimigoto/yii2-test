<?php

declare(strict_types=1);

namespace app\factories;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\Sms;
use app\models\Task;
use app\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class HistoryRelationFactory
{
    private const OBJECT_CLASSES = [
        Customer::class,
        Sms::class,
        Task::class,
        Call::class,
        Fax::class,
        User::class,
    ];

    /** @var ActiveRecord */
    private $owner;

    public function __construct(ActiveRecord $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param string $name
     *
     * @return ActiveQuery|null
     */
    public function getRelation(string $name): ?ActiveQuery
    {
        $getter = 'get' . $name;
        $class = $this->getClassNameByRelation($name);

        if ($class !== null && !method_exists($this->owner, $getter)) {
            return $this->owner->hasOne($class, ['id' => 'object_id']);
        }

        return null;
    }

    /**
     * Returns table name of ActiveRecord model with $className
     *
     * @param string $className
     *
     * @return string
     */
    private function getObjectByTableClassName(string $className): string
    {
        if (method_exists($className, 'tableName')) {
            return str_replace(['{', '}', '%'], '', $className::tableName());
        }

        return $className;
    }

    /**
     * Returns class name of ActiveRecord model
     *
     * @param $relation
     *
     * @return string|null
     */
    private function getClassNameByRelation($relation): ?string
    {
        foreach (self::OBJECT_CLASSES as $class) {
            if ($this->getObjectByTableClassName($class) === $relation) {
                return $class;
            }
        }

        return null;
    }
}
