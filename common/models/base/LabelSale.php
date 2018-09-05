<?php

namespace common\models\base;

use Yii;

/**
 * This is the base model class for table "label_sale".
 *
 * @property integer $id
 * @property integer $label_id
 * @property integer $sale_id
 *
 * @property \common\models\Labels $label
 * @property \common\models\Sales $sale
 */
class LabelSale extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label_id', 'sale_id'], 'required'],
            [['label_id', 'sale_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'label_sale';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label_id' => 'Label ID',
            'sale_id' => 'Sale ID',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(\common\models\Labels::className(), ['id' => 'label_id']);
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


}
