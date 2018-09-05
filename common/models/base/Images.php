<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "images".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $ext
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \common\models\OrderProduct[] $orderProducts
 */
class Images extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'name', 'ext'], 'required','message'=>'{attribute} не может быть пустым'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'name', 'ext'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('frontend_images','Название'),
            'name' => Yii::t('frontend_images','Имя файла'),
            'ext' => Yii::t('frontend_images','Расширение'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderCarts()
    {
        return $this->hasMany(\common\models\OrderCart::className(), ['image_id' => 'id']);
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
        ];
    }
}
