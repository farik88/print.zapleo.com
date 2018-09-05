<?php
namespace common\services;
use common\helpers\ExtArrayHelper as EAH;
use frontend\core\exceptions\ServiceAuthException;
use common\services\bundles\InstagramBundle;
use \yii;

/**
 * Class Instagram
 * @package common\services
 */
class Instagram extends BaseService
{

    //key for yii params
    const PARAMS_KEY = 'instagramApiKey';
    const PARAMS_SECRET = 'instagramApiSecret';
    const SESSION_TOKEN_KEY = 'instagramToken';
    const SESSION_PROFILE_KEY = 'instagramProfile';
    /**
     * @var null|InstagramBundle
     */
    private $_cachedBundle = null;


    private $defaultPerms = [
        'basic',
        'likes',
        'public_content',
        'relationships'
    ];

//    private $points = [
//        'self-media-recent' => 'https://api.instagram.com/v1/users/self/media/recent/',
//        'self-info' => 'https://api.instagram.com/v1/users/self',
//    ];

    /**
     * @return mixed|null
     */
    public static function hasAccessToken(){
        return self::getFromSession(self::SESSION_TOKEN_KEY);
    }
    
    public static function hasUserInfo() {
        return self::getFromSession(self::SESSION_PROFILE_KEY);
    }
    

    /**
     * Instagram constructor.
     * @param $token
     * @param array $config keys for config equal to keys for Bundle constructor: apiKey, apiSecret
     * @param InstagramBundle|null $bundle if is null, construct create new object with Bundle and configs
     */
    public function __construct($token = null, $config = [], InstagramBundle $bundle = null)
    {
   //     $this->initDefaults();
        (!is_null($bundle))
            ? $this->setBundle( $bundle, $config ) //prepare existing bundle
            : $this->getBundle( $config ); //register a new bundle
        $token = self::hasAccessToken();
        $this->setToken($token);
    }

    /**
     * @param $token
     * @throws \Exception
     */
    public function setToken($token) {
        $this->_cachedBundle->setAccessToken($token);
    }

    /**
     * set closure for default fields, each one needed to userId or other dynamic data
     */
//    protected function initDefaults() {
//        $this->points['user-media-recent'] = function($userId) {
//            return 'https://api.instagram.com/v1/users/'.$userId.'/media/recent/';
//        };
//        $this->points['user-info'] = function($userId) {
//            return 'https://api.instagram.com/v1/users/'.$userId;
//        };
//    }



    /** get cached bundle or create a new bundle
     * @param array $config keys: apiKey, apiSecret, apiCallback
     * @param bool $cache
     * @return InstagramBundle|null
     */
    public function getBundle($config = [], $cache = true) {
        $defaultCallbackUrl = yii\helpers\Url::to('/instagram/remember-user',true);
        if (is_null($this->_cachedBundle)) {
            $bundle = new InstagramBundle([
                'apiKey'      => EAH::getByIssetKey('apiKey', $config, $this->getKey()),
                'apiSecret'   => EAH::getByIssetKey('apiSecret', $config, $this->getSecret()),
                'apiCallback' => EAH::getByIssetKey('apiCallback', $config, $defaultCallbackUrl ),
            ]);
            if(($token = $this->getFromSession(self::SESSION_TOKEN_KEY)) && (!is_object($token))) {
                $bundle->setAccessToken($token);
            }
            if($cache) {
                $this->setBundle($bundle);
            }
        }
        else {
            $bundle = $this->_cachedBundle;
        }
        return $bundle;
    }

    /**
     * @param InstagramBundle $bundle
     * @param array $config
     */
    public function setBundle(InstagramBundle $bundle, $config = []) {
        //todo make as list of keys
        if(isset($config['apiCallback'])) {
            $bundle->setApiKey($config['apiCallback']);
        }
        if(isset($config['apiKey'])) {
            $bundle->setApiKey($config['apiKey']);
        }
        if(isset($config['apiSecret'])) {
            $bundle->setApiKey($config['apiSecret']);
        }
        $this->_cachedBundle = $bundle;
    }
    
    /**
     * @param $code
     * @param InstagramBundle|null $bundle
     * @return bool
     */
    public function registerToken($code, InstagramBundle $bundle = null) {
        if(is_null($bundle)) {
            $bundle = $this->_cachedBundle;
        }
        $token = $bundle->getOAuthToken($code);
        if(!property_exists($token, 'access_token')) {
            //todo remake with exception
            return false;
        }
        $this->setToSession(self::SESSION_TOKEN_KEY, $token->access_token);
        $this->setToSession(self::SESSION_PROFILE_KEY, $token->user);
        $bundle->setAccessToken($token->access_token);
        return true;
    }



    /**
     * @param array $perms
     * @return string
     * @throws \Exception
     */
    public function getLoginUrl($perms = []) {
        if(empty($perms)) {
            $perms = $this->defaultPerms;
        }
        return $this->getBundle()->getLoginUrl($perms);
    }
    
    public function rmToken() {
        $this->rmFromSession(self::SESSION_TOKEN_KEY);
    }


    /**
     * @param $type
     * @return array|mixed
     * @throws ServiceAuthException
     */
    public function getMedia($type) {
        if($type != 'self') {
            $user = $this->_cachedBundle->searchUser($type, 20);
            if($user->meta->code == 400) {
              //  $this->rmToken();
                throw new ServiceAuthException("Fail instagram authorization", $user);
            }
            if(!isset($user->data, $user->data[0],$user->data[0]->id )) {
                return [];
            }
            $type = $user->data[0]->id;
        }
        return $this->_cachedBundle->getUserMedia($type,20);
    }
}