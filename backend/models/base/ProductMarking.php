<?php

namespace backend\models\base;

use Yii;

/**
 * This is the base model class for table "product_marking".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $marking_id
 *
 * @property \backend\models\Products $product
 * @property \backend\models\Markings $marking
 */
class ProductMarking extends \common\components\base\BaseActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'marking_id'], 'required'],
            [['product_id', 'marking_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_marking';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'marking_id' => 'Разметки',
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
    public function getMarking()
    {
        return $this->hasOne(\backend\models\Markings::className(), ['id' => 'marking_id']);
    }
    }
