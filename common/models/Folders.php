<?php

namespace common\models;

use \common\models\base\Folders as BaseFolders;

/**
 * This is the model class for table "folders".
 */
class Folders extends BaseFolders
{
    const FT_BACKGROUNDS = 2; 
    const FT_EMOJI = 0; 
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['parent_folder', 'created_at', 'updated_at', 'type_id'], 'integer'],
            [['name', 'type_id'], 'required'],
            [['name'], 'string', 'max' => 255]
        ]);
    }

    public function afterFind()
    {
        $this->name = \Yii::t('backend_'.self::tableName().'_name', $this->name);

        return parent::afterFind(); // TODO: Change the autogenerated stub
    }
	
}
