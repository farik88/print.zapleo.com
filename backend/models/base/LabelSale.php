<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "label_sale".
 *
 * @property integer $id
 * @property integer $label_id
 * @property integer $sale_id
 *
 * @property \backend\models\Labels $label
 * @property \backend\models\Sales $sale
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
            'label_id' => 'Метка',
            'sale_id' => 'Скидка',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(\backend\models\Labels::className(), ['id' => 'label_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(\backend\models\Sales::className(), ['id' => 'sale_id']);
    }
    }
