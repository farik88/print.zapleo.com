<?php

namespace backend\controllers;

use backend\models\Languages;
use common\components\utils\ProductsUtils;
use common\models\SourceLangMessage;
use Yii;
use backend\models\Products;
use backend\models\ProductsSearch;
use backend\core\base\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends BackendController
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerOrderCart = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orderCarts,
        ]);
        $providerProductColor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productColors,
        ]);
        $providerProductCoupon = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCoupons,
        ]);
        $providerProductCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCovers,
        ]);
        $providerProductLabel = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productLabels,
        ]);
        $providerProductMarking = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productMarkings,
        ]);
        $providerProductSale = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productSales,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerOrderCart' => $providerOrderCart,
            'providerProductColor' => $providerProductColor,
            'providerProductCoupon' => $providerProductCoupon,
            'providerProductCover' => $providerProductCover,
            'providerProductLabel' => $providerProductLabel,
            'providerProductMarking' => $providerProductMarking,
            'providerProductSale' => $providerProductSale,
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
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
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing Products model.
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
     * Export Products information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id) {
        $model = $this->findModel($id);
        $providerOrderCart = new \yii\data\ArrayDataProvider([
            'allModels' => $model->orderCarts,
        ]);
        $providerProductColor = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productColors,
        ]);
        $providerProductCoupon = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCoupons,
        ]);
        $providerProductCover = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productCovers,
        ]);
        $providerProductLabel = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productLabels,
        ]);
        $providerProductMarking = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productMarkings,
        ]);
        $providerProductSale = new \yii\data\ArrayDataProvider([
            'allModels' => $model->productSales,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerOrderCart' => $providerOrderCart,
            'providerProductColor' => $providerProductColor,
            'providerProductCoupon' => $providerProductCoupon,
            'providerProductCover' => $providerProductCover,
            'providerProductLabel' => $providerProductLabel,
            'providerProductMarking' => $providerProductMarking,
            'providerProductSale' => $providerProductSale,
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for OrderCart
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddOrderCart()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('OrderCart');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formOrderCart', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ProductColor
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
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
    
    /**
    * Action to load a tabular form grid
    * for ProductLabel
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProductLabel()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductLabel');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductLabel', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ProductMarking
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProductMarking()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductMarking');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductMarking', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for ProductSale
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddProductSale()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('ProductSale');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProductSale', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateActive($id){

        $value = $this->getRequest('post','val');

        $del_active = Products::findOne($id);
        $del_active->active = $value;

        return ($del_active->save()) ? 200 : 400;

    }
    /**
     * @return array
     */
    public function actionLoadFileCover()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstancesByName('ProductCover')[0];

        return  ['file_id'=> (new ProductsUtils())->loadFileCover($file)];
    }

    /**
     * @return array
     */
    public function actionLoadFileColor()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstancesByName('ProductColor')[0];

        return  ['file_id'=> (new ProductsUtils())->loadFileColor($file)];
    }
}
