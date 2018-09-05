<?php

namespace common\models;

use \common\models\base\Payments as BasePayments;

/**
 * This is the model class for table "payments".
 */
class Payments extends BasePayments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'file_id'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'active', 'file_id'], 'integer'],
            [['comment'], 'string'],
            [['title'], 'string', 'max' => 255]
        ]);
    }

    public function afterFind()
    {
        $this->title = \Yii::t('backend_'.self::tableName().'_title', $this->title);

        return parent::afterFind(); // TODO: Change the autogenerated stub
    }
}
