<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use backend\models\Languages;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Markings;
use backend\models\MarkingsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarkingsController implements the CRUD actions for Markings model.
 */
class MarkingsController extends BackendController
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'pdf'],
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
     * Lists all Markings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarkingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Markings model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Markings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Markings();
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
     * Updates an existing Markings model.
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
        $model_msg = SourceLangMessage::findOne(['category' => 'backend_'.$model::tableName().'_name','owner_id' => $id]);

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
     * Deletes an existing Markings model.
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
        $markings = $this->findModel($id);

        if (file_exists('uploads/markings/'.$markings->name)) {
            unlink('uploads/markings/'.$markings->name);
        }

        // Delete translate
        SourceLangMessage::findOne(['category' => 'backend_'.$markings::tableName().'_name','owner_id' => $id])->delete();
        $markings->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Markings information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
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
     * Finds the Markings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Markings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Markings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
