<?php

namespace backend\models;

use \backend\models\base\Deliveries as BaseDeliveries;
use \common\traits\SimpleYiiTrait;


/**
 * This is the model class for table "deliveries".
 */
class Deliveries extends BaseDeliveries
{
    use SimpleYiiTrait;

    const DEL_ACTIVE = 1;
    const DEL_DISABLED = 0;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'file_id', 'price', 'active'], 'required'],
            [['file_id', 'price', 'active', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255],
        ]);
    }

    public function afterFind()
    {
        $this->title = \Yii::t('backend_'.self::tableName().'_title', $this->title);

        return parent::afterFind(); // TODO: Change the autogenerated stub
    }
}
