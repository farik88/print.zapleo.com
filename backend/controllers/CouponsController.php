<?php

namespace backend\controllers;

use backend\core\base\BackendController;
use Yii;
use backend\models\Coupons;
use backend\models\CouponsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CouponsController implements the CRUD actions for Coupons model.
 */
class CouponsController extends BackendController
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
     * Lists all Coupons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CouponsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coupons model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerCouponCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->couponCovers,
        ]);
        $providerCouponLabel = new \yii\data\ArrayDataProvider([
            'allModels' => $model->couponLabels,
        ]);
        $providerOrders = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orders,
        ]);
        $providerProductCoupon = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCoupons,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerCouponCover' => $providerCouponCover,
            'providerCouponLabel' => $providerCouponLabel,
            'providerOrders' => $providerOrders,
            'providerProductCoupon' => $providerProductCoupon,
        ]);
    }

    /**
     * Creates a new Coupons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Coupons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Coupons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Coupons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * 
     * Export Coupons information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerCouponCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->couponCovers,
        ]);
        $providerCouponLabel = new \yii\data\ArrayDataProvider([
            'allModels' => $model->couponLabels,
        ]);
        $providerOrders = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orders,
        ]);
        $providerProductCoupon = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCoupons,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerCouponCover' => $providerCouponCover,
            'providerCouponLabel' => $providerCouponLabel,
            'providerOrders' => $providerOrders,
            'providerProductCoupon' => $providerProductCoupon,
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
     * Finds the Coupons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coupons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coupons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for CouponCover
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
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
    * for CouponLabel
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddCouponLabel()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('CouponLabel');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formCouponLabel', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Orders
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
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
    * Action to load a tabular form grid
    * for ProductCoupon
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProductCoupon()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductCoupon');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductCoupon', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionUpdateActive($id){

        $value = $this->getRequest('post','val');

        $del_active = Coupons::findOne($id);
        $del_active->active = $value;

        return ($del_active->save()) ? 200 : 400;

    }
}
