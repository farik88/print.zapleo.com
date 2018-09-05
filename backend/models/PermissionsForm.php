<?php

namespace backend\models;

use backend\models\Permissions;
use Yii;
use yii\base\Exception;

class PermissionsForm extends Permissions{
    
    public function save()
    {
        $auth = Yii::$app->authManager;
        $permission_exist = $auth->getPermission($this->name);
        if(!$permission_exist){
            $newPermission = $auth->createPermission($this->name);
            $newPermission->description = $this->description;
            $auth->add($newPermission);
        }else{
            throw new Exception('Permission named "' . $this->name . '" already exist!');
        }
    }
    
    public function update($origin_name)
    {
        $auth = Yii::$app->authManager;
        $permission_exist = $auth->getPermission($this->name);
        if($origin_name === $this->name || !$permission_exist){
            Yii::$app->db->createCommand()->update('auth_item', ['description' => $this->description], 'name = :origin_name', [':origin_name' => $origin_name])->execute();
            Yii::$app->db->createCommand()->update('auth_item', ['name' => $this->name], 'name = :origin_name', [':origin_name' => $origin_name])->execute();
        }else{
            throw new Exception('Permission named "' . $this->name . '" already exist!');
        }
    }
    
}
