<?php

namespace backend\models;

use backend\models\base\Roles as BaseRoles;
use Yii;
use yii\data\ArrayDataProvider;
use yii\base\Exception;

class Roles extends BaseRoles
{
    public static function getRolesArrDataProvider()
    {
        $models = array();
        $roles = Yii::$app->authManager->getRoles();
        if(!empty($roles)){
            foreach ($roles as $role){
                $models[] = [
                    'name' => $role->name,
                    'is_default_role' => self::is_default_role($role)
                ];
            }
            $provider = new ArrayDataProvider([
                'allModels' => $models,
                'pagination' => [
                    'pageSize' => 100,
                ],
                'sort' => [
                    'attributes' => ['name', 'is_default_role'],
                ],
            ]);
            return $provider;
        }else{
            return false;
        }
    }
    
    public static function addRole($params)
    {
        $errors = [];
        $name = $params['name'];
        $is_exist_role = Yii::$app->authManager->getRole($name);
        if(empty($name) || !is_string($name) || strlen($name) > 100){
            $errors['name'] = [
                'message' => Yii::t('back_models_base_roles', 'Введите корректные данные'),
                'data' => $name
            ];
        }elseif($is_exist_role !== NULL){
            $errors['name'] = [
                'message' => Yii::t('back_models_base_roles', 'Такая роль уже существует'),
                'data' => $name
            ];
        }
        if(empty($errors)){
            $auth = Yii::$app->authManager;
            $new_role = $auth->createRole($name);
            $auth->add($new_role);
            return true;
        }else{
            return $errors;
        }
    }
    
    public static function updateRole($post)
    {
        if(isset($post['Role']['origin_name']) && isset($post['Role']['name']) && ($post['Role']['origin_name'] !== $post['Role']['name'])){
            $new_name = trim($post['Role']['name']);
            $old_name = trim($post['Role']['origin_name']);
            Yii::$app->db->createCommand()->update('auth_item', ['name' => $new_name], 'name = :old_name', [':old_name' => $old_name])->execute();
        }
        if(isset($post['Role']['is_default_role']) && !empty($post['Role']['is_default_role'])){
            Yii::$app->db->createCommand()->update('auth_item', ['is_default_role' => NULL], 'is_default_role = 1')->execute();
            Yii::$app->db->createCommand()->update('auth_item', ['is_default_role' => '1'], 'name = :name', [':name' => $post['Role']['name']])->execute();
        }
    }

    public static function deleteRole($name = null)
    {
        if($name){
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($name);
            return $auth->remove($role);
        }else{
            throw new Exception('Incorrect role $name in deleteRole method');
        }
    }
    
    public static function getRoleByName($name = null)
    {
        if($name){
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($name);
            return $role ? $role : false;
        }else{
            throw new Exception('Incorrect role $name in getRoleByName method');
        }
    }

    public static function is_default_role($role)
    {
        $query_res =Yii::$app->getDb()->createCommand('SELECT is_default_role FROM auth_item WHERE type = 1 AND name = :name', [':name' => $role->name])->queryOne()['is_default_role'];
        if($query_res){
            return true;
        }else{
            return false;
        }
    }
}