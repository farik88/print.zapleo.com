<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_label".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $label_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Labels $label
 */
class ProductLabel extends \common\components\base\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'label_id'], 'required'],
            [['product_id', 'label_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_label';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'label_id' => 'Метка',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(\backend\models\Products::className(), ['id' => 'product_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabel()
    {
        return $this->hasOne(\backend\models\Labels::className(), ['id' => 'label_id']);
    }
    }
