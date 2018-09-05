<?php
namespace backend\controllers;

use backend\core\base\BaseController;
use backend\models\Markings;
use backend\models\Users;
use common\components\utils\SiteUtils;
use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','load-file','load-resource','load-images','load-marking-prod','load-marking','left'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    private function getSumByDays($days = 7){
        $dates = [];
        $res = \Yii::$app->db->createCommand("SELECT  SUM(total) as sum, DATE(data) as diff From orders WHERE DATEDIFF(data, NOW())>-:days GROUP by diff",[':days'=>$days])->queryAll();
        $res = ArrayHelper::map($res,'diff','sum');

        for($i = $days - 1; $i>=0 ; $i--){
            $diff = new \DateInterval('P'.$i.'D');
            $diff->invert = 1;
            $date = new \DateTime();
            $date->add($diff);
            (isset($res[$date->format('Y-m-d')]))
                ? $dates[] = ['data'=>$date->format('Y-m-d'),'val'=>$res[$date->format('Y-m-d')]]
                : $dates[] = ['data'=>$date->format('Y-m-d'),'val'=>0];


        }
        return $dates;
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $graph['7'] = $this->getSumByDays();
        $graph['30'] =$this->getSumByDays(30);
        $graph['365'] =$this->getSumByDays(365);
        return $this->render('index',[
            'graph'=>$graph
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionLoadFile()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        return  ['file_id'=> (new SiteUtils())->loadFile($file)];
    }


    public function actionLoadResource()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        return  ['file_id'=> (new SiteUtils())->loadResource($file)];
    }


    public function actionLoadImages()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        return  ['file_id'=> (new SiteUtils())->loadPrint($file)];
    }

    public function actionLoadMarking()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $file = UploadedFile::getInstancesByName('file')[0];
        $file->saveAs('uploads/markings/'. $file->baseName . '.' . $file->extension);

        $db_mark = new Markings();
//        $db_mark->name = $file->baseName.'.'.$file->extension;
//        $db_mark->title = $db_mark->name;

        $db_mark->save();

        return  ['file_id'=> $db_mark->id];
    }

    public function actionLoadMarkingProd($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstancesByName('file')[0];

        return  ['file_id'=> (new SiteUtils())->loadMarkingProd($file,$id)];
    }


    public function actionLeft(){
        $model = new Users();

        echo $this->render('/layouts/main',[
            'model'=>$model
        ]);
    }
}
