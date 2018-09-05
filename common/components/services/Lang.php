<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 25.05.17
 * Time: 18:24
 */

namespace common\components\services;

use Yii;
use common\models\Languages;

class Lang extends Languages{

    /**
     * Variable, to store the current language object
     */
    static $current = null;
    
    /**
     *  Getting the current language object
     */
    static function getCurrent()
    {
        if( self::$current === null ){
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }
    
    /**
     * Set the current language object and user locale
     */
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->iso_code;
    }
    
    /**
     * Get the default language object
     */
    static function getDefaultLang()
    {
        return Lang::find()->where('`is_default` = :is_default', [':is_default' => 1])->one();
    }
    
    /**
     * Obtaining a language object by letter identifier
     */
    static function getLangByUrl($url = null)
    {
        if ($url === null || empty($url)) {
            return null;
        } else {
            $language = Lang::find()->where('url = :url', [':url' => $url])->one();
            if ( $language === null ) {
                return null;
            }else{
                return $language;
            }
        }
    }
    
    static public function getLangSwitchUrl()
    {
        $current_route = Yii::$app->controller->getRoute();
        /* Remove index parts */
        $url_parse_1 = str_replace('site/index', '', $current_route);
        $url = str_replace('/index', '', $url_parse_1);
        /* Action params */
        if(isset(Yii::$app->controller->actionParams) && !empty(Yii::$app->controller->actionParams)){
            foreach (Yii::$app->controller->actionParams as $param){
                $url .= '/' . $param;
            }
        }
        /* Get params */
        $url_parts = explode('?', Yii::$app->request->url);
        if(count($url_parts)>1){
            $gets = $url_parts[(count($url_parts)-1)];
            $url = $url . '?' . $gets;
        }
        return $url;
    }

}