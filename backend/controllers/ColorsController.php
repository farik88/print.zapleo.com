<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use backend\models\Languages;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Colors;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ColorsController implements the CRUD actions for Colors model.
 */
class ColorsController extends BackendController
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'pdf', 'add-product-color'],
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
     * Lists all Colors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Colors::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Colors model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerProductColor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productColors,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerProductColor' => $providerProductColor,
        ]);
    }

    /**
     * Creates a new Colors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Colors();
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
     * Updates an existing Colors model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save(['productColors'])) {
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
     * Deletes an existing Colors model.
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
        $model = $this->findModel($id);

        // Delete translate
        SourceLangMessage::findOne(['category' => 'backend_'.$model::tableName().'_name','owner_id' => $id])->delete();
        $model->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Colors information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerProductColor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productColors,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerProductColor' => $providerProductColor,
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
     * Finds the Colors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Colors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Colors::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddProductColor()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductColor');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductColor', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
