<?php

namespace backend\models;

use backend\models\base\Permissions as BasePermissions;
use yii\data\ArrayDataProvider;
use Yii;

class Permissions extends BasePermissions
{
    
    public static function getArrDataProvider()
    {
        $models = array();
        $permissions = Yii::$app->authManager->getPermissions();
        if(!empty($permissions)){
            foreach ($permissions as $permission){
                $models[] = [
                    'name' => $permission->name,
                    'description' => $permission->description,
                ];
            }
            $provider = new ArrayDataProvider([
                'allModels' => $models,
                'pagination' => [
                    'pageSize' => 100,
                ],
                'sort' => [
                    'attributes' => ['name'],
                ],
            ]);
            return $provider;
        }else{
            return false;
        }
    }
    
    public static function deletePermission($name = null)
    {
        if($name){
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($name);
            return $auth->remove($permission);
        }else{
            throw new Exception('Incorrect permission $name in deletePermission method');
        }
    }
}
