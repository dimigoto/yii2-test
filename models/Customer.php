<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property integer $id
 * @property string $name
 */
class Customer extends ActiveRecord
{
    private const QUALITY_ACTIVE = 'active';
    private const QUALITY_REJECTED = 'rejected';
    private const QUALITY_COMMUNITY = 'community';
    private const QUALITY_UNASSIGNED = 'unassigned';
    private const QUALITY_TRICKLE = 'trickle';

    private const TYPE_LEAD = 'lead';
    private const TYPE_DEAL = 'deal';
    private const TYPE_LOAN = 'loan';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Returns associative array of readable customer qualities. Key of array is quality code
     *
     * @return array
     */
    public static function getQualityTexts(): array
    {
        return [
            self::QUALITY_ACTIVE => Yii::t('app', 'Active'),
            self::QUALITY_REJECTED => Yii::t('app', 'Rejected'),
            self::QUALITY_COMMUNITY => Yii::t('app', 'Community'),
            self::QUALITY_UNASSIGNED => Yii::t('app', 'Unassigned'),
            self::QUALITY_TRICKLE => Yii::t('app', 'Trickle'),
        ];
    }

    /**
     * Returns readable quality text by quality code
     *
     * @param $quality
     *
     * @return string|null
     */
    public static function getQualityTextByQuality($quality): ?string
    {
        return self::getQualityTexts()[$quality] ?? $quality;
    }

    /**
     * Returns associative array of readable customer types. Key of array is type code
     *
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return [
            self::TYPE_LEAD => Yii::t('app', 'Lead'),
            self::TYPE_DEAL => Yii::t('app', 'Deal'),
            self::TYPE_LOAN => Yii::t('app', 'Loan'),
        ];
    }

    /**
     * Returns readable type text by type code
     *
     * @param $type
     *
     * @return mixed
     */
    public static function getTypeTextByType($type): string
    {
        return self::getTypeTexts()[$type] ?? $type;
    }
}
