<?php

namespace backend\controllers;
use Yii;
use backend\core\base\BackendController as BackendController;
use backend\models\PermissionsForm;
use backend\models\Permissions;
use yii\helpers\Url;
use yii\base\Exception;

class PermissionsController extends BackendController
{
    public function actionIndex()
    {
        $dataProvider = PermissionsForm::getArrDataProvider();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate()
    {
        $form_model = new PermissionsForm();
        if ($form_model->load(Yii::$app->request->post()) && $form_model->validate()){
            $form_model->save();
            return $this->redirect('index');
        } else {
            return $this->render('create', ['form_model' => $form_model]);
        }
    }
    
    public function actionDelete($name = null)
    {
        if (!empty($name)) {
            Permissions::deletePermission($name);
            return $this->redirect(Url::toRoute('index'));
        } else {
            throw new Exception('Dont have name of role to delete!');
        }
    }
    
    public function actionUpdate($name = null)
    {
        $post = Yii::$app->request->post();
        if(!empty($post)){
            $form_model = new PermissionsForm();
            if ($form_model->load($post) && $form_model->validate()){
                $form_model->update($post['PermissionsForm']['origin_name']);
            }
            return $this->redirect('index');
        }
        if($name){
            $form_model = new PermissionsForm();
            $permission = Yii::$app->authManager->getPermission($name);
            if($permission){
                return $this->render('update', [
                    'form_model' => $form_model,
                    'permission' => $permission,
                ]);
            }else{
                throw new Exception("Can't find permission by name = '" . $name . "'");
            }
        }else{
            throw new Exception('PermissionsController - actionUpdate - No GET parameter "name". Check url');
        }
    }
    
}
