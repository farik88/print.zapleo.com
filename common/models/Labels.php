<?php

namespace common\models;

use \common\models\base\Labels as BaseLabels;

/**
 * This is the model class for table "labels".
 */
class Labels extends BaseLabels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ]);
    }

    public function afterFind()
    {
        $this->name = \Yii::t('backend_'.self::tableName().'_name', $this->name);

        return parent::afterFind(); // TODO: Change the autogenerated stub
    }
}
