<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 12.05.17
 * Time: 7:58
 */

namespace common\traits;

use \yii; 

trait SessionTrait
{

    /** eq. $_SESSION with yii shell
     * @param null|string $key
     * @return mixed|null|\yii\web\Session
     */
    public function getSession($key = null)
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        return (!is_null($key) && isset($session[$key]))
            ? $session[$key]
            : $session;
    }

    /**
     * @param $key mixed in session
     * @return mixed|null
     */
    public function getFromSession($key)
    {
        $session = self::getSession(); //this is trait, so we need use functions with self::
        return (!is_null($session) && isset($session[$key]))
            ? $session[$key]
            : null;

    }

    /**
     * @param $key
     * @return mixed
     */
    public function rmFromSession($key)
    {
        $session = self::getSession();
        return $session->remove($key);
    }

    /**
     * @param $arr
     * @param bool $rewrite
     */
    public function setSessionArray($arr,$rewrite = true)
    {
        $session = self::getSession();
        foreach($arr as $k => $v) {
            if(!$rewrite && $session->get($k)) {
                continue;
            }
            $session->set($k,$v);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param bool $rewrite
     */
    public function setToSession($key,$value, $rewrite = true) {
        $session = self::getSession();
        if(!$rewrite && $session->get($key)) {
            return;
        }
        $session->set($key,$value);
    }

    /**
     * @param $msg
     * @param string $type
     */
    public function userMsg($msg,$type='error')
    {
        Yii::$app->getSession()->setFlash($type, $msg);
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasMsg($key)
    {
        return Yii::$app->getSession()->hasFlash($key);
    }
}