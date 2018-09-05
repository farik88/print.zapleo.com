<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "payments".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $active
 * @property string $comment
 * @property integer $file_id
 *
 * @property \common\models\Orders[] $orders
 * @property \common\models\Files $file
 */
class Payments extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    const PAY_ACTIVE = 1;
    const PAY_DISABLED = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'file_id'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'active', 'file_id'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('frontend_payments','Название'),
            'active' => Yii::t('frontend_payments','Статус'),
            'comment' => Yii::t('frontend_payments','Коментарий'),
            'file_id' => Yii::t('frontend_payments','Изображение'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(\common\models\Orders::className(), ['payment_id' => 'id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\common\models\Files::className(), ['id' => 'file_id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
