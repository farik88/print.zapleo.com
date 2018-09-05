<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 22.05.17
 * Time: 11:10
 */

namespace common\components\services;


class User extends \yii\web\User
{
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }
}