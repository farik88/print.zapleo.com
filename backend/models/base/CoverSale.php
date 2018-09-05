<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "cover_sale".
 *
 * @property integer $id
 * @property integer $sale_id
 * @property integer $cover_id
 *
 * @property \backend\models\Sales $sale
 * @property \backend\models\Covers $cover
 */
class CoverSale extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_id', 'cover_id'], 'required'],
            [['sale_id', 'cover_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cover_sale';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Акция',
            'cover_id' => 'Чехол',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(\backend\models\Sales::className(), ['id' => 'sale_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCover()
    {
        return $this->hasOne(\backend\models\Covers::className(), ['id' => 'cover_id']);
    }
    }
