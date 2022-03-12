<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $statusText
 */
class User extends ActiveRecord
{
    private const STATUS_DELETED = 0;
    private const STATUS_HIDDEN = 1;
    private const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['username', 'created_at', 'updated_at'], 'required'],
            [[
                'status',
                'created_at',
                'updated_at',
            ], 'integer'],
            [[
                'username',
                'email',
            ], 'string', 'max' => 255],

            [['username'], 'unique'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_HIDDEN]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username (login)'),
            'statusText' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Returns associative array of readable status texts. Key of array is a status code
     *
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
            self::STATUS_HIDDEN => Yii::t('app', 'Hidden'),
        ];
    }

    /**
     * Returns readable text of user status
     *
     * @return string
     */
    public function getStatusText(): string
    {
        return self::getStatusTexts()[$this->status] ?? $this->status;
    }
}
