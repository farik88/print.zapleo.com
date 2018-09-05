<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use backend\models\Languages;
use common\models\LangMessage;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Covers;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CoversController implements the CRUD actions for Covers model.
 */
class CoversController extends BackendController
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
        ];
    }

    /**
     * Lists all Covers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Covers::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Covers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerCouponCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->couponCovers,
        ]);
        $providerCoverSale = new \yii\data\ArrayDataProvider([
            'allModels' => $model->coverSales,
        ]);
        $providerProductCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCovers,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerCouponCover' => $providerCouponCover,
            'providerCoverSale' => $providerCoverSale,
            'providerProductCover' => $providerProductCover,
        ]);
    }

    /**
     * Creates a new Covers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Covers();
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
     * Updates an existing Covers model.
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
     * Deletes an existing Covers model.
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
     * Finds the Covers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Covers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Covers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddCouponCover()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('CouponCover');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formCouponCover', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for CoverSale
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddCoverSale()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('CoverSale');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formCoverSale', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ProductCover
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProductCover()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductCover');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductCover', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateActive($id){

        $value = $this->getRequest('post','val');

        $cover_active = \backend\models\base\Covers::findOne($id);
        $cover_active->active = $value;

        return ($cover_active->save()) ? 200 : 400;

    }
}
