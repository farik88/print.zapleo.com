<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 23.05.17
 * Time: 9:25
 */

namespace frontend\controllers;
use frontend\core\utils\ProfilesUtil;
use yii;
use frontend\core\base\FrontendController;

/**
 * Class ProfileController
 * @package frontend\controllers
 */
class ProfileController extends FrontendController
{
    /** todo make user info and user profile as prepared in cache
     * action Profile User
     * @return string
     */
    public function actionIndex(){
        return $this->render('room', (new ProfilesUtil())->getProfile());
    }

    /** for ajax request. Change user info - addresses or nickname\mail
     * @return array
     */
    public function actionSetInfoUser(){
        $util = new ProfilesUtil();
        $addressId = $this->getRequest('post', 'address_id');
        $result = (!$addressId)
            ? $util->setUserInfo($this->getRequest())
            : $util->setUserAddress($addressId, $this->getRequest('post', 'address')) ;
        return $this->jsonResponseObj($result);
    }

    /** for ajax request. Add new address for the user.
     * @return array
     */
    public function actionAddUserAddress(){
        $address = $this->getRequest('post','val');
        return $this->jsonResponseObj( (new ProfilesUtil())->addSelfAddress($address) );
    }
}