<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 23.05.17
 * Time: 9:26
 */

namespace frontend\controllers;

use common\models\CouponCover;
use common\models\CouponLabel;
use common\models\Coupons;
use common\models\Deliveries;
use common\models\LoginForm;
use common\models\OrderCart;
use common\models\Orders;
use common\models\Payments;
use common\models\ProductCoupon;
use common\models\Products;
use common\models\UserAddress;
use common\models\Users;
use common\services\LiqPay;
use frontend\core\base\FrontendController;
use frontend\core\utils\CartsUtil;
use frontend\core\utils\CouponsUtil;
use frontend\core\utils\OrdersUtil;
use frontend\core\utils\SalesUtil;
use frontend\models\SignupForm;
use yii;

class OrderController extends FrontendController
{
    /**
     * Edit count product in Cart
     *
     * @return int
     */
    public function actionEditCount(){
        //@todo Сделать правильное вычисление цены и количества при активном купоне
        $val = $this->getRequest('post','val');
        $cart_id = $this->getRequest('post','cart_id');

        $cart = OrderCart::findOne($cart_id);
        $product = Products::findOne($cart->product_id);
        $cart->count = $val;
        $coupon = Coupons::findOne($cart->coupon_id);

        $discontCount = 0;
        $allCart = (new CartsUtil())->getSelfCart();
        foreach($allCart as $k=> $v) {
            if($v['id'] == $cart_id) {
                $discont = (new SalesUtil())->detectSale($v);
                if($discont){
                    $discontCount =  (($discont && isset($discont['sale_val']))
                        ? $discont['sale_val']
                        : $coupon->value );
                    break;
                }
            }
        }

        $cart->total = (($product->price - $discontCount )*$val);
        return ($cart->save()) ? 200 : 400;
    }
    


    /**
     * @return string
     */
    public function actionIndex(){

        if(Yii::$app->getUser()->id){
            $command = Yii::$app->db->createCommand("UPDATE order_cart SET user_id = :user_id WHERE order_id is null and  user_hash=:user_hash", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()])->execute();
            return $this->redirect(['/order/by-case']);
        }
        $login = new LoginForm();
        $signup = new SignupForm();

        $userHash = $this->getFromSession('id');
        $cart = (new CartsUtil())->getSelfCart();

        $cart = (new OrdersUtil())->searchProductAndColor($cart);

        if ($signup->load(Yii::$app->request->post())) {
            if ($user = $signup->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $command = Yii::$app->db->createCommand("UPDATE order_cart SET user_id = :user_id WHERE order_id is null and  user_hash=:user_hash", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()])->execute();
                    return $this->redirect(['/order/by-case']);
                }
            }
        }

        if ($login->load(Yii::$app->request->post()) && $login->login()) {
            $command = Yii::$app->db->createCommand("UPDATE order_cart SET user_id = :user_id WHERE order_id is null and  user_hash=:user_hash", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()])->execute();
            return $this->redirect(['/order/by-case']);
        }else{
            $msg = $login->getErrors();            //@todo показать вывод сообщение
        }

        return $this->render('index',[
            'cart' => $cart,
            'sum' => \common\models\OrderCart::find()->where(['user_hash' => $userHash ])->sum('total'),
            'login'=>$login,
            'signup'=>$signup,
            'msg' => $msg

        ]);
    }

    public function actionCreate(){
        $delivery_id = $this->getRequest('post','delivery_id');
        $payment_id = $this->getRequest('post','payment_id');
        $comment = $this->getRequest('post','comment');
        $address = $this->getRequest('post','address');

        $command = Yii::$app->db->createCommand("SELECT sum(total) FROM order_cart WHERE order_id is null and (user_id=:user_id or user_hash=:user_hash)", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()]);
        $sum = $command->queryScalar();

        $order = new Orders();

        $order->user_id = Yii::$app->getUser()->id;
        $order->data = date('Y-m-d H:i:s',time());
        $order->delivery_id = $delivery_id;
        $order->payment_id = $payment_id;
        $order->comment = $comment;
        $order->status_delivery = \common\models\Orders::DELIVERY_EXPECTATION;
        $order->status_payment = \common\models\Orders::PAYMENT_EXPECTATION;
        $order->address = $address;
        $order->total = $sum;
        if ($order->save()){
            Yii::$app->db->createCommand("UPDATE order_cart SET order_id = :order_id WHERE order_id is null and  user_id=:user_id", [':order_id' => $order->id,':user_id'=>$this->getUserId()])->execute();
        }else{
            return $this->jsonBadResponseObj('not saved',$order->getErrors());
        }
        return $order->id;
    }

    public function actionCheckCoupon(){
        $hash = $this->getRequest('post','hash');
        $cart = (new CartsUtil())->getSelfCart();
        $util = new CouponsUtil();
        $coupon = $util->getCoupon($hash);
        $cup = $util->applyCoupon($coupon, $cart);
        return $this->jsonResponseObj($cup);
    }

    public function actionByCase(){
        $user = Users::findOne(Yii::$app->getUser()->id);//->toArray();
        $address = UserAddress::find()->where(['user_id'=>Yii::$app->getUser()->id])->asArray()->all();
        $payment = Payments::find()->where(['active'=>Payments::PAY_ACTIVE])->asArray()->all();
        $delivery = Deliveries::find()->where(['active'=> Deliveries::DEL_ACTIVE])->asArray()->all();
        $cart = (new CartsUtil())->getSelfCart();
        $cart = (new OrdersUtil())->searchProductAndColor($cart);
        $command = Yii::$app->db->createCommand("SELECT sum(total) FROM order_cart WHERE order_id is null and (user_id=:user_id or user_hash=:user_hash)", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()]);
        $sum = $command->queryScalar();
        return $this->render('bycase',[
            'user' => $user,
            'address' =>$address,
            'payment'=>$payment,
            'delivery'=>$delivery,
            'cart' => $cart,
            'sum' => $sum
        ]);
    }

    public function actionPayOrder($id){
        $order = Orders::findOne($id);
        $params = [
          //'price'=> $order->total,
          'order_id' => $order->id
        ];
       return (new LiqPay())->sendOrder($params);
    }
}