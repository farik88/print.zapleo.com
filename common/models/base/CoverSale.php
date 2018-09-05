<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "cover_sale".
 *
 * @property integer $id
 * @property integer $sale_id
 * @property integer $cover_id
 *
 * @property \common\models\Sales $sale
 * @property \common\models\Covers $cover
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
            'sale_id' => 'Sale ID',
            'cover_id' => 'Cover ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(\common\models\Sales::className(), ['id' => 'sale_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveSale()
    {
        return $this->hasOne(\common\models\Sales::className(), ['id' => 'sale_id'])->where(['active'=>1])
            ->addSelect("*, (if(type <>1, CONCAT('UAH'), CONCAT('%'))) AS type_text ");
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCover()
    {
        return $this->hasOne(\common\models\Covers::className(), ['id' => 'cover_id']);
    }
    }
