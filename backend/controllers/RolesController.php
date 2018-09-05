<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use backend\models\Roles;
use Yii;
use yii\helpers\Url;
use yii\base\Exception;

class RolesController extends BackendController
{
    
    public function actionIndex()
    {
        $dataProvider = Roles::getRolesArrDataProvider();
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionCreate()
    {
        /* Post processing */
        if(isset(Yii::$app->request->post()['Role'])){
            $create_result = Roles::addRole(Yii::$app->request->post()['Role']);
            if($create_result === true){
                /* Role was created */
                return $this->redirect(Url::toRoute('index'));
            }else{
                /* Has errors */
                return $this->render('create', [
                    'create_result' => $create_result
                ]);
            }
        }
        /* Default create render */
        return $this->render('create');
    }
    
    public function actionDelete($name = null)
    {
        if (!empty($name)) {
            Roles::deleteRole($name);
            return $this->redirect(Url::toRoute('index'));
        } else {
            throw new Exception('Dont have name of role to delete!');
        }
    }
    
    public function actionUpdate($name = null)
    {
        $post = Yii::$app->request->post();
        if(!empty($post)){
            Roles::updateRole($post);
            return $this->redirect('index');
        }
        if($name){
            $role = Roles::getRoleByName($name);
            if($role){
                return $this->render('update', [
                    'role' => $role,
                    'is_default_role' => Roles::is_default_role($role),
                ]);
            }else{
                throw new Exception('Error with role getting in actionUpdate method');
            }
        }else{
            throw new Exception('No GET parameter "name". Check url');
        }
    }
    
}
