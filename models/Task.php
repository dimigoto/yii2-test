<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $status
 * @property string $title
 * @property string $text
 * @property string $due_date
 * @property integer $priority
 * @property string $ins_ts
 *
 * @property string $stateText
 * @property string $state
 * @property string $subTitle
 *
 * @property boolean $isOverdue
 * @property boolean $isDone
 *
 * @property User $user
 *
 *
 * @property string $isInbox
 * @property string $statusText
 */
class Task extends ActiveRecord
{
    private const STATUS_NEW = 0;
    private const STATUS_DONE = 1;
    private const STATUS_CANCEL = 3;

    private const STATE_INBOX = 'inbox';
    private const STATE_DONE = 'done';
    private const STATE_FUTURE = 'future';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id', 'customer_id', 'status', 'priority'], 'integer'],
            [['text'], 'string'],
            [['title', 'object'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'status' => Yii::t('app', 'Status'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Description'),
            'due_date' => Yii::t('app', 'Due Date'),
            'formatted_due_date' => Yii::t('app', 'Due Date'),
            'priority' => Yii::t('app', 'Priority'),
            'ins_ts' => Yii::t('app', 'Ins Ts'),
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
            self::STATUS_DONE => Yii::t('app', 'Complete'),
            self::STATUS_CANCEL => Yii::t('app', 'Cancel'),
        ];
    }

    /**
     * Returns readable status text by status code
     *
     * @param int $value
     *
     * @return string|int
     */
    public function getStatusTextByValue(int $value)
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * Returns readable task status
     *
     * @return string
     */
    public function getStatusText()
    {
        return $this->getStatusTextByValue($this->status);
    }

    /**
     * Returns associative array of readable state texts. Key of array is a state code
     *
     * @return array
     */
    public static function getStateTexts(): array
    {
        return [
            self::STATE_INBOX => Yii::t('app', 'Inbox'),
            self::STATE_DONE => Yii::t('app', 'Done'),
            self::STATE_FUTURE => Yii::t('app', 'Future')
        ];
    }

    /**
     * Returns readable task state
     *
     * @return string
     */
    public function getStateText(): string
    {
        return self::getStateTexts()[$this->state] ?? $this->state;
    }

    /**
     * Returns true if the task is overdue
     *
     * @return bool
     */
    public function getIsOverdue(): bool
    {
        return $this->status !== self::STATUS_DONE && strtotime($this->due_date) < time();
    }

    /**
     * Returns true if the task is completed
     *
     * @return bool
     */
    public function getIsDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }
}
