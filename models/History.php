<?php

namespace app\models;

use app\models\traits\ObjectNameTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%history}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $customer_id
 * @property string $event
 * @property string $object
 * @property integer $object_id
 * @property string $message
 * @property string $detail
 * @property integer $user_id
 *
 * @property string $eventText
 *
 * @property Customer $customer
 * @property User $user
 *
 * @property Task $task
 * @property Sms $sms
 * @property Call $call
 */
class History extends ActiveRecord
{
    use ObjectNameTrait;

    public const EVENT_CREATED_TASK = 'created_task';
    public const EVENT_UPDATED_TASK = 'updated_task';
    public const EVENT_COMPLETED_TASK = 'completed_task';

    public const EVENT_INCOMING_SMS = 'incoming_sms';
    public const EVENT_OUTGOING_SMS = 'outgoing_sms';

    public const EVENT_INCOMING_CALL = 'incoming_call';
    public const EVENT_OUTGOING_CALL = 'outgoing_call';

    public const EVENT_INCOMING_FAX = 'incoming_fax';
    public const EVENT_OUTGOING_FAX = 'outgoing_fax';

    public const EVENT_CUSTOMER_CHANGE_TYPE = 'customer_change_type';
    public const EVENT_CUSTOMER_CHANGE_QUALITY = 'customer_change_quality';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['ins_ts'], 'safe'],
            [['customer_id', 'object_id', 'user_id'], 'integer'],
            [['event'], 'required'],
            [['message', 'detail'], 'string'],
            [['event', 'object'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Ins Ts'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'event' => Yii::t('app', 'Event'),
            'object' => Yii::t('app', 'Object'),
            'object_id' => Yii::t('app', 'Object ID'),
            'message' => Yii::t('app', 'Message'),
            'detail' => Yii::t('app', 'Detail'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * Returns relation declaration with Customer entity
     *
     * @return ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * Returns relation declaration with User entity
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Returns associative array of readable event texts. Key of array is event code
     *
     * @return array
     */
    public static function getEventTexts(): array
    {
        return [
            self::EVENT_CREATED_TASK => Yii::t('app', 'Task created'),
            self::EVENT_UPDATED_TASK => Yii::t('app', 'Task updated'),
            self::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),

            self::EVENT_INCOMING_SMS => Yii::t('app', 'Incoming message'),
            self::EVENT_OUTGOING_SMS => Yii::t('app', 'Outgoing message'),

            self::EVENT_CUSTOMER_CHANGE_TYPE => Yii::t('app', 'Type changed'),
            self::EVENT_CUSTOMER_CHANGE_QUALITY => Yii::t('app', 'Property changed'),

            self::EVENT_OUTGOING_CALL => Yii::t('app', 'Outgoing call'),
            self::EVENT_INCOMING_CALL => Yii::t('app', 'Incoming call'),

            self::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            self::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),
        ];
    }

    /**
     * Returns readable event text by event code
     *
     * @param $event
     *
     * @return string
     */
    public static function getEventTextByEvent($event): string
    {
        return static::getEventTexts()[$event] ?? $event;
    }

    /**
     * Returns readable history event
     *
     * @return string
     */
    public function getEventText(): string
    {
        return static::getEventTextByEvent($this->event);
    }


    /**
     * Returns detail of changed $attribute as StdObject or null if attribute doesn't exist
     *
     * @param $attribute
     *
     * @return object|null
     */
    public function getDetailChangedAttribute($attribute)
    {
        $detail = json_decode($this->detail, false);
        return $detail->changedAttributes->{$attribute} ?? null;
    }

    /**
     * Returns old value of $attribute or null
     *
     * @param $attribute
     *
     * @return string|null
     */
    public function getDetailOldValue($attribute): ?string
    {
        $detail = $this->getDetailChangedAttribute($attribute);
        return $detail->old ?? null;
    }

    /**
     * Returns new value of $attribute or null
     *
     * @param $attribute
     *
     * @return string|null
     */
    public function getDetailNewValue($attribute): ?string
    {
        $detail = $this->getDetailChangedAttribute($attribute);
        return $detail->new ?? null;
    }

    /**
     * Returns detail data of $attribute or null if doesn't exist
     *
     * @param $attribute
     *
     * @return object|null
     */
    public function getDetailData($attribute)
    {
        $detail = json_decode($this->detail, false);
        return $detail->data->{$attribute} ?? null;
    }
}
