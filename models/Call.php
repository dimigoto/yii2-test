<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%call}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $direction
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $phone_from
 * @property string $phone_to
 * @property string $comment
 *
 * -- magic properties
 * @property string $statusText
 * @property string $directionText
 * @property string $totalStatusText
 * @property string $totalDisposition
 * @property string $durationText
 * @property string $fullDirectionText
 * @property string $client_phone
 *
 * @property Customer $customer
 * @property User $user
 */
class Call extends ActiveRecord
{
    private const STATUS_NO_ANSWERED = 0;
    public const STATUS_ANSWERED = 1;

    public const DIRECTION_INCOMING = 0;
    private const DIRECTION_OUTGOING = 1;

    public $duration = 720;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%call}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['ins_ts'], 'safe'],
            [['direction', 'phone_from', 'phone_to', 'type', 'status', 'viewed'], 'required'],
            [['direction', 'user_id', 'customer_id', 'type', 'status'], 'integer'],
            [['phone_from', 'phone_to', 'outcome'], 'string', 'max' => 255],
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
            'ins_ts' => Yii::t('app', 'Date'),
            'direction' => Yii::t('app', 'Direction'),
            'directionText' => Yii::t('app', 'Direction'),
            'user_id' => Yii::t('app', 'User ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'status' => Yii::t('app', 'Status'),
            'statusText' => Yii::t('app', 'Status'),
            'phone_from' => Yii::t('app', 'Caller Phone'),
            'phone_to' => Yii::t('app', 'Dialed Phone'),
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
     * Returns client phone number
     *
     * @return string
     */
    public function getClientPhone(): string
    {
        return $this->direction === self::DIRECTION_INCOMING ? $this->phone_from : $this->phone_to;
    }

    /**
     * Returns readable final status text
     *
     * @return string|int
     */
    public function getTotalStatusText()
    {
        if ($this->isMissedCall()) {
            return Yii::t('app', 'Missed Call');
        }

        if (!$this->isClientAnswer()) {
            return Yii::t('app', 'Client No Answer');
        }

        $msg = $this->getFullDirectionText();

        if ($this->duration) {
            $msg .= ' (' . $this->getDurationText() . ')';
        }

        return $msg;
    }

    /**
     * TODO: Странное поведение метода. Нужно уточнить
     *
     * @param bool $hasComment
     *
     * @return string
     */
    public function getTotalDisposition(bool $hasComment = true): string
    {
        $t = [];

        if ($hasComment && $this->comment) {
            $t[] = $this->comment;
        }

        return implode(': ', $t);
    }

    /**
     * Returns associative array of readable call directions. Key of array is direction code
     *
     * @return array
     */
    public static function getFullDirectionTexts(): array
    {
        return [
            self::DIRECTION_INCOMING => Yii::t('app', 'Incoming Call'),
            self::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing Call'),
        ];
    }

    /**
     * Returns readable call direction
     *
     * @return string|int
     */
    public function getFullDirectionText()
    {
        return self::getFullDirectionTexts()[$this->direction] ?? $this->direction;
    }

    /**
     * @return string
     */
    public function getDurationText(): string
    {
        if ($this->duration === null) {
            return '00:00';
        }

        return $this->isOverAnHourCall()
            ? gmdate("H:i:s", $this->duration)
            : gmdate("i:s", $this->duration);
    }

    /**
     * Returns true if call missed
     *
     * @return bool
     */
    public function isMissedCall(): bool
    {
        return $this->status === self::STATUS_NO_ANSWERED
            && $this->direction === self::DIRECTION_INCOMING;
    }

    /**
     * Returns true if client didn't answer
     *
     * @return bool
     */
    public function isClientAnswer(): bool
    {
        return $this->status !== self::STATUS_NO_ANSWERED
            && $this->direction === self::DIRECTION_OUTGOING;
    }

    /**
     * Returns call comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment ?? '';
    }

    /**
     * Returns true if call duration more or equal an hour
     *
     * @return bool
     */
    private function isOverAnHourCall(): bool
    {
        if ($this->duration === null) {
            return false;
        }

        return $this->duration >= 3600;
    }
}
