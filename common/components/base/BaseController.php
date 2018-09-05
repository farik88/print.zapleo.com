<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 15.02.17
 * Time: 15:01
 */
namespace common\components\base;

use common\models\User;
use common\traits\SessionTrait;
use common\traits\SimpleYiiTrait;
use yii;

class BaseController extends \yii\web\Controller
{
    use SimpleYiiTrait, SessionTrait;

    /**
     * BaseController constructor.
     * @param string $id
     * @param yii\base\Module $module
     * @param array $config
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->on(self::EVENT_BEFORE_ACTION,[$this,"setActivity"]);
    }

    /**
     * 
     */
    public function setActivity() {
        if (!($id = $this->getUserId())) {
            return;
        }
        // Code to Set the last seen time for the user.
        $user = User::findOne($id);
        $user->last_active = date('Y-m-d H:i:s');
        $user->save();
    }
    
    
    public function getRequest($method="post",$variable=null,$def=null)
    {
        switch($method)
        {
            case "post":case "get":
            break;
            case "request":
                //?
            default:
                return null;
        }

        if(is_null($variable))
        {
            return  \Yii::$app->request->$method(); //->post or ->get
        }
        return \Yii::$app->request->$method($variable,$def); // ->post or ->get  ($var,$def);
    }

    /**
     * 
     */
    public function returnFormatJson()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * @return bool|mixed
     */
    protected function isAjax() {
        return Yii::$app->request->isAjax;
    }
    
    /** for json response
     * @param array $data
     * @param string $status
     * @param null $code
     * @return array with states like status and data, for json response
     */
    protected function jsonResponseObj($data = [], $status ='success', $code = null) {
        $this->returnFormatJson();
        return [
            'status' => $status,
            'code' => $code,
            'data' => $data
        ];
    }

    /** like jsonResponseObj, but with "error" binding
     * @param $msg
     * @param array $errors
     * @param string $status
     * @return array
     */
    protected function jsonBadResponseObj($msg, $errors = [], $status = "error") {
        return $this->jsonResponseObj([
            'message' => $msg,
            'errors' => $errors
        ], $status, 500);
    }
}