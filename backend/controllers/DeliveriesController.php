<?php

namespace backend\controllers;


use backend\core\base\BackendController;
use backend\models\Languages;
use common\components\utils\DeliveriesUtils;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Deliveries;
use backend\models\DeliveriesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\traits\SimpleYiiTrait;

/**
 * DeliveriesController implements the CRUD actions for Deliveries model.
 */
class DeliveriesController extends BackendController
{
    use SimpleYiiTrait;
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
                        'actions' => ['index','upload','load-file','view', 'create', 'update', 'delete', 'pdf', 'add-orders','update-active'],
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
     * Lists all Deliveries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliveriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Deliveries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerOrders = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orders,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerOrders' => $providerOrders,
        ]);
    }

    /**
     * Creates a new Deliveries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Deliveries();

        $model_msg = new SourceLangMessage();
        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->save_translate($model, $model_msg);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_msg' => $model_msg,
                'langs' => $langs
            ]);
        }
    }

    /**
     * Updates an existing Deliveries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_msg = SourceLangMessage::findOne(['category' => 'backend_'.$model::tableName().'_title','owner_id' => $id]);

        if (is_null($model_msg))
            $model_msg = new SourceLangMessage();

        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->save_translate($model, $model_msg);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_msg' => $model_msg,
                'langs' => $langs
            ]);
        }
    }

    /**
     * Deletes an existing Deliveries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
//        $file = Files::findOne($delivery->file_id);
//        unlink('uploads/'. $file->name.'.'.$file->ext);
//
//        $delFile = new Files();
//        $delFile->findModel($delivery->file_id)->delete();

        $model = $this->findModel($id);

        // Delete translate
        SourceLangMessage::findOne(['category' => 'backend_'.$model::tableName().'_title','owner_id' => $id])->delete();
        $model->delete();


        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Deliveries information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerOrders = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orders,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerOrders' => $providerOrders,
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
     * Finds the Deliveries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deliveries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Deliveries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddOrders()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Orders');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formOrders', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * action for load file
     *
     * @return array
     */
    public function actionLoadFile()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstancesByName('file')[0];

        return  ['file_id'=> (new DeliveriesUtils())->loadFile($file)];
    }

    public function actionUpdateActive($id){

        $value = $this->getRequest('post','val');

        $del_active = Deliveries::findOne($id);
        $del_active->active = $value;

        return ($del_active->save()) ? 200 : 400;

    }
}
