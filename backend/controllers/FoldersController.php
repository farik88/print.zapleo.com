<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use backend\models\Languages;
use backend\models\Resources;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Folders;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FoldersController implements the CRUD actions for Folders model.
 */
class FoldersController extends BackendController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','load-resources','load-resources-fonts','fonts','emoji','background', 'view', 'create', 'update', 'delete','deleteb', 'pdf', 'add-resources', 'remove-resources'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Folders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Folders::find(),
        ]);

        return $this->render('index', [
            'type' => 'index.page',
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLoadResources($id){

        $folder_id = $id;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        $folder = \backend\models\base\Folders::findOne($folder_id);
        if($folder->type_id == Folders::TYPE_BACKGROUND){
            $file->saveAs('uploads/resources/background/'.$folder->name.'/'. $file->baseName . '.' . $file->extension);
        }else if($folder->type_id == Folders::TYPE_EMOJI){
            $file->saveAs('uploads/resources/emoji/'.$folder->name.'/'. $file->baseName . '.' . $file->extension);
        }

        $resourcer = new Resources();
        $resourcer->name = $file->baseName;
        $resourcer->ext  = $file->extension;
        $resourcer->title = $resourcer->name.'.'.$resourcer->ext;
        $resourcer->folder_id = $id;
        $resourcer->save();

        return  [
            'file_id'=> $resourcer->id,
            'file_name'=> $resourcer->name,
            'file_ext'=> $resourcer->ext,
            'file_title'=> $resourcer->name.'.'.$resourcer->ext,
        ];
    }

    public function actionLoadResourcesFonts(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        $file->saveAs('uploads/resources/fonts/'. $file->baseName . '.' . $file->extension);

        $resourcer = new Resources();
        $resourcer->name = $file->baseName;
        $resourcer->ext  = $file->extension;
        $resourcer->title = $resourcer->name.'.'.$resourcer->ext;
        $resourcer->save();

        return  ['file_id'=> $resourcer->id];
    }

    public function actionFonts() {
        $dataProvider = new ActiveDataProvider([
            'query' => \backend\models\base\Resources::find()->where(['folder_id' => NULL]),
        ]);

        return $this->render('fonts', [
            'type' => Folders::TYPE_FONTS,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmoji() {
        $dataProvider = new ActiveDataProvider([
            'query' => Folders::find()->where(['type_id' => Folders::TYPE_EMOJI]),
        ]);

        return $this->render('index', [
            'type' => Folders::TYPE_EMOJI,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBackground() {
        $dataProvider = new ActiveDataProvider([
            'query' => Folders::find()->where(['type_id' => Folders::TYPE_BACKGROUND]),
        ]);

        return $this->render('index', [
            'type' => Folders::TYPE_BACKGROUND,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Folders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerResources = new \yii\data\ArrayDataProvider([
            'allModels' => $model->resources,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerResources' => $providerResources,
        ]);
    }

    /**
     * Creates a new Folders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param $type
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate($type)
    {
        $model = new Folders();
        $model_msg = new SourceLangMessage();
        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->save_translate($model, $model_msg);

            if($type == $model::TYPE_BACKGROUND){
                $path = 'uploads/resources/background/'.$model->name;
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
                return $this->redirect(['view', 'id' => $model->id]);
            }else if($type == $model::TYPE_EMOJI){
                $path = 'uploads/resources/emoji/'.$model->name;
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'model_msg' => $model_msg,
                'langs' => $langs
            ]);
        }
    }

    /**
     * Updates an existing Folders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Folders::findOne($id);
        $model_msg = SourceLangMessage::findOne(['category' => 'backend_'.$model::tableName().'_name','owner_id' => $id]);

        if (is_null($model_msg))
            $model_msg = new SourceLangMessage();

        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();

        if(!empty($_POST['Folders'])){
            $this->save_translate($model, $model_msg);

            if( $_POST['Folders']['type_id'] == Folders::TYPE_EMOJI){
                rename('uploads/resources/emoji/'.$model->name,'uploads/resources/emoji/'.$_POST['Folders']['name']);
            }
            if( $_POST['Folders']['type_id'] == Folders::TYPE_BACKGROUND){
                rename('uploads/resources/background/'.$model->name,'uploads/resources/background/'.$_POST['Folders']['name']);
            }
            $model->name = $_POST['Folders']['name'];
            $model->type_id = $_POST['Folders']['type_id'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            return $this->render('update', [
                'model' => $model,
                'model_msg' => $model_msg,
                'langs' => $langs
            ]);
        }
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Folders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {

        $resources =  \backend\models\base\Resources::findOne($id);

        if($resources->folder_id == Null){
            $path = 'uploads/resources/fonts/'. $resources->name.'.'.$resources->ext;
            if(file_exists($path)){
                unlink($path);
            }

            $resources->delete();
        }

        return $this->redirect(['fonts']);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \yii\base\ErrorException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteb($id){

        $folder = $this->findModel($id);

        FileHelper::removeDirectory('uploads/resources/background/'.$folder->name);
        SourceLangMessage::findOne(['category' => 'backend_'.$folder::tableName().'_name','owner_id' => $id])->delete();

        $folder->delete();

        return $this->redirect(['/folders/background']);
    }
    
    /**
     * 
     * Export Folders information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerResources = new \yii\data\ArrayDataProvider([
            'allModels' => $model->resources,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerResources' => $providerResources,
        ]);

        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_CORE,
            'format' => \kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
            'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => \Yii::$app->name],
            'methods' => [
                'SetHeader' => [\Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }

    
    /**
     * Finds the Folders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Folders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Folders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddResources()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Resources');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formResources', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRemoveResources($id){
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('resources', ['id' => $id])
            ->execute();
    }
}
