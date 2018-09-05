<?php
namespace frontend\controllers;
use frontend\core\base\FrontendController;
use frontend\core\utils\ProductsUtil;
use frontend\core\utils\ResourcesUtil;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use yii\web\Cookie;

/** site means constructor
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /**
     * action HomePage
     *
     * @return string
     */
    public function actionIndex()
    {
        $util = new ProductsUtil();
        return $this->render('index',[
            'labels' => $util->getLabels(),
            'products'=> $util->getProducts()
        ]);
    }

    /**
     * @param $id int product id
     * @return string
     */
    public function actionCreate($id){
        //it's ok
        return $this->render( 'create', (new ProductsUtil())->getCreationParams($id) );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ( 
            $this->getUserId() 
            || 
            ( $model->load( $this->getRequest() ) && $model->login() )
        ) {
            return $this->redirect(['/profile/index']);
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(['/profile/index']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function actionTakeFile(){
        return $this->jsonResponseObj((new ProductsUtil())->getProductCover($this->getRequest()));
    }
    
    public function actionTestAjax()
    {
        return $this->jsonResponseObj(['test'=>1]);
    }
    
    public function actionChangeConstructorHelpTourStatus(){
        $tour_status = Yii::$app->request->post('help_tour_status');
        if($tour_status && ($tour_status === 'finished')){
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'help_was_read',
                'value' => 'was read'
            ]));
        }
        return $this->jsonResponseObj(['result' => 'cookie was set']);
    }

    /**
     * @param $id int folder id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionTakeBackg($id){
        return $this->jsonResponseObj( (new ResourcesUtil())->getResourcesByFolder($id) );
    }

    public function actionFaq(){
        return $this->render('FAQ',[

        ]);
    }
}
