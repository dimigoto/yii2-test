<?php

namespace app\models\traits;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\Sms;
use app\models\Task;
use app\models\User;

trait ObjectNameTrait
{
    public static $classes = [
        Customer::class,
        Sms::class,
        Task::class,
        Call::class,
        Fax::class,
        User::class,
    ];

    /**
     * @inheritdoc
     */
    public function getRelation($name, $throwException = true)
    {
        $getter = 'get' . $name;
        $class = self::getClassNameByRelation($name);

        if ($class !== null && !method_exists($this, $getter)) {
            return $this->hasOne($class, ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }

    /**
     * Returns table name of ActiveRecord model with $className
     *
     * @param string $className
     *
     * @return string
     */
    public static function getObjectByTableClassName(string $className): string
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
    public static function getClassNameByRelation($relation): ?string
    {
        foreach (self::$classes as $class) {
            if (self::getObjectByTableClassName($class) === $relation) {
                return $class;
            }
        }

        return null;
    }
}
