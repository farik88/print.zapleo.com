<?php

namespace backend\controllers;

use Yii;
use backend\core\base\BackendController;
use \common\models\base\LangMessage;
use common\models\base\SourceLangMessage;
use common\models\SourceLangMessageSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Languages;

/**
 * SourceLangsController implements the CRUD actions for SourceLangMessage model.
 */
class SourceLangsController extends BackendController
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'add-message'],
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
     * Lists all SourceLangMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceLangMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single SourceLangMessage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerMessage = new \yii\data\ArrayDataProvider([
            'allModels' => $model->messages,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerMessage' => $providerMessage,
        ]);
    }

    /**
     * Creates a new SourceLangMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SourceLangMessage();
        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(!empty(Yii::$app->request->post()['translations'])){
                LangMessage::updateTranslationsFromArray($model->id, Yii::$app->request->post()['translations']);
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Updates an existing SourceLangMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $langs = Languages::find()->where(['is', 'is_default', NULL])->andWhere(['active' => 1])->all();
        
        if(!empty(Yii::$app->request->post()['translations'])){
            LangMessage::updateTranslationsFromArray($id, Yii::$app->request->post()['translations']);

            if (!empty(Yii::$app->request->post('translate_all'))) {
                $messages = SourceLangMessage::findAll(['message' => $model->message]);

                foreach ($messages as $message) {
                    LangMessage::updateTranslationsFromArray($message->id, Yii::$app->request->post()['translations']);
                }
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'langs' => $langs,
            ]);
        }
    }

    /**
     * Deletes an existing SourceLangMessage model.
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
     * Finds the SourceLangMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SourceLangMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SourceLangMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Action to load a tabular form grid
    * for Message
    * @author Yohanes Candrajaya <moo.tensai@gmail.com>
    * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
    *
    * @return mixed
    */
    public function actionAddMessage()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Message');
            if((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formMessage', ['row' => $row]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
