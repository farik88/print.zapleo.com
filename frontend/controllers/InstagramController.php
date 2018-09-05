<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.05.17
 * Time: 9:16
 */

namespace frontend\controllers;

use common\services\Instagram;
use frontend\core\exceptions\ServiceAuthException;
use \yii;
use frontend\core\base\FrontendController;

class InstagramController extends FrontendController
{
    /**
     * @return yii\web\Response
     * @throws yii\web\MethodNotAllowedHttpException
     */
    public function actionRememberUser() {
        $code = Yii::$app->request->get('code');
        $errors = $profile = [];
        $insta = new Instagram();
        if(!$code || ! $insta->registerToken($code)) {
            $errors = "Instagram fail"; //todo set errors
        }
        else {
            $profile = Instagram::hasUserInfo();
        }
        $some = $insta->getMedia('self');
        return $this->render("child-window", [
            'errors' => $errors,
            'profile' => $profile
        ]);
    }

    /**
     *
     */
    public function actionGetPhotos() {

        $type = Yii::$app->request->get('type');
        try {
            return $this->jsonResponseObj((new Instagram())->getMedia($type));
        }
        catch (ServiceAuthException $e) {
            return $this->jsonBadResponseObj($e->getMessage(), $e->getErrors());
        }
    }

}