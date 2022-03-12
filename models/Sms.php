<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sms}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $phone_from
 * @property string $message
 * @property string $ins_ts
 * @property integer $direction
 * @property string $phone_to
 * @property integer $type
 * @property string $formatted_message
 *
 * @property string $statusText
 * @property string $directionText
 *
 * @property Customer $customer
 * @property User $user
 */
class Sms extends ActiveRecord
{
    public const DIRECTION_INCOMING = 0;
    public const DIRECTION_OUTGOING = 1;

    // incoming
    private const STATUS_NEW = 0;
    private const STATUS_READ = 1;
    private const STATUS_ANSWERED = 2;

    // outgoing
    private const STATUS_DRAFT = 10;
    private const STATUS_WAIT = 11;
    private const STATUS_SENT = 12;
    private const STATUS_DELIVERED = 13;
    private const STATUS_FAILED = 14;
    private const STATUS_SUCCESS = 13;


    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%sms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['phone_to', 'direction'], 'required'],
            [['user_id', 'customer_id', 'status', 'direction', 'applicant_id', 'type'], 'integer'],
            [['message'], 'string'],
            [['ins_ts'], 'safe'],
            [['phone_from', 'phone_to'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'status' => Yii::t('app', 'Status'),
            'statusText' => Yii::t('app', 'Status'),
            'phone_from' => Yii::t('app', 'Phone From'),
            'phone_to' => Yii::t('app', 'Phone To'),
            'message' => Yii::t('app', 'Message'),
            'ins_ts' => Yii::t('app', 'Date'),
            'direction' => Yii::t('app', 'Direction'),
            'directionText' => Yii::t('app', 'Direction'),
            'user.fullname' => Yii::t('app', 'User'),
            'customer.name' => Yii::t('app', 'Client'),
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
     * Returns associative array of readable status texts. Key of array is a status code
     *
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_READ => Yii::t('app', 'Read'),
            self::STATUS_ANSWERED => Yii::t('app', 'Answered'),

            self::STATUS_DRAFT => Yii::t('app', 'Draft'),
            self::STATUS_WAIT => Yii::t('app', 'Wait'),
            self::STATUS_SENT => Yii::t('app', 'Sent'),
            self::STATUS_DELIVERED => Yii::t('app', 'Delivered'),
        ];
    }

    /**
     * Returns readable status text by status code
     *
     * @param $value
     *
     * @return string|int
     */
    public static function getStatusTextByValue($value)
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * Returns readable sms status
     *
     * @return string
     */
    public function getStatusText(): string
    {
        return self::getStatusTextByValue($this->status);
    }

    /**
     * Returns associative array of readable directions texts. Key of array is a direction code
     *
     * @return array
     */
    public static function getDirectionTexts(): array
    {
        return [
            self::DIRECTION_INCOMING => Yii::t('app', 'Incoming'),
            self::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing'),
        ];
    }

    /**
     * Returns readable direction text by direction code
     *
     * @param $value
     *
     * @return string|int
     */
    public static function getDirectionTextByValue($value)
    {
        return self::getDirectionTexts()[$value] ?? $value;
    }

    /**
     * Returns readable sms direction
     *
     * @return string
     */
    public function getDirectionText(): string
    {
        return self::getDirectionTextByValue($this->direction);
    }
}
