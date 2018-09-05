<?php

namespace backend\models\base;

use yii\base\Model;
use Yii;

class Permissions extends Model{
    
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 3, 'max' => 255],
            [['description'], 'string', 'max' => 500],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('backend_permissions', 'Название права пользователя'),
            'description' => Yii::t('backend_permissions', 'Краткое описание'),
        ];
    }
    
}
