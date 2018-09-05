<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 29.05.17
 * Time: 12:03
 */

namespace common\services;



use common\helpers\ExtArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class LiqPay extends BaseService
{
    //const for liqpay app
    const PARAMS_KEY = 'liqpayApiKey';
    const PARAMS_SECRET = 'liqpayApiSecret';

    private $liqpay;

    public function __construct()
    {
        $pubKey = $this->getKey();
        $secKey =$this->getSecret();
        return  $this->liqpay = (new \delagics\liqpay\LiqPay($pubKey,$secKey));
    }

    public function getLiqPay(){
        return $this->liqpay;
    }

    public function sendOrder($params=[]){
       $htmlButton = $this->liqpay->cnb_form(array(
            'version'        => ExtArrayHelper::getByIssetKey("version", $params, "3"),
            'amount'         => ExtArrayHelper::getByIssetKey("price", $params, "0.1"),
            'currency'       => ExtArrayHelper::getByIssetKey("currency", $params, "UAH"),
            'description'    => ExtArrayHelper::getByIssetKey("description", $params, "Buy case on mycase"),
            'order_id'       => ExtArrayHelper::getByIssetKey("order_id", $params, "1"),
           ));

       return $htmlButton;
    }

    /**
     * @param $order_id
     * @return string
     */
    public function getStatusOrder($order_id){

        return $this->liqpay->api("request", array(
            'action'        => 'status',
            'version'       => "3",
            'order_id'      => $order_id,
        ));
    }
}