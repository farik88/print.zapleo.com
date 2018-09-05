<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 25.05.17
 * Time: 11:35
 */

namespace frontend\controllers;


use backend\models\base\OrderCart;
use common\models\base\Products;
use frontend\core\base\FrontendController;
use frontend\core\utils\CartsUtil;
use frontend\core\utils\SalesUtil;

class CartController extends FrontendController
{
    /**
     * Page cart
     *
     * @return string
     */
    public function actionIndex(){
        $cart = (new CartsUtil())->getSelfCart();
        for ($i = 0, $size = count($cart); $i < $size; $i++){
            $file_id = \common\models\ProductCover::find()->select('file_id')->where(['product_id'=>$cart[$i]['product_id'],'cover_id'=>$cart[$i]['cover_id'],'color_id'=>$cart[$i]['color_id']])->asArray()->one();
            $cover_color = \common\models\Files::find()->where(['id'=>$file_id])->asArray()->one();
            $cart[$i]['producrt_cover_color_file_id'] = $cover_color;

            $prod_file_id = \common\models\ProductColor::find()->select('file_id')->where(['product_id'=>$cart[$i]['product_id'],'color_id'=>$cart[$i]['color_id']])->asArray()->one();
            $product_color = \common\models\Files::find()->where(['id'=>$prod_file_id])->asArray()->one();
            $cart[$i]['producrt_color_file_id'] = $product_color;
        }
        /**
         * @todo ActiveQuery
         */
        $command = \Yii::$app->db->createCommand("SELECT sum(total) FROM order_cart WHERE order_id is null and (user_id=:user_id or user_hash=:user_hash)", [':user_hash' => $this->getFromSession('id'),':user_id'=>$this->getUserId()]);
        $sum = $command->queryScalar();

        return $this->render('index',[
            'cart' => $cart,
            'sum' => $sum,
        ]);

    }
    
    /**
     * Remove product in cart
     *
     * @param $id
     * @return int
     */
    public function actionRemove($id){
        $cart = OrderCart::findOne($id)->delete();
        return ($cart) ? 200 : 400;
    }

    /**
     * Add product to cart
     * @return int
     */
    public function actionAdd()
    {
        $product_id = $this->getRequest('post','product_id');
        $image_id = $this->getRequest('post','image_id');
        $product = \common\models\Products::find()->where(['id' => $product_id])->one();
        $total = $product->price;
        $count = $this->getRequest('post','count');
        $cover_id = $this->getRequest('post','cover_id');
        $color_id = $this->getRequest('post','color_id');

        $cart = new OrderCart();
        $cart->product_id = $product_id;
        $cart->image_id = $image_id;
        $cart->total = $total;
        $cart->count = $count;
        $cart->cover_id = $cover_id;
        $cart->user_id =$this->getUserId();
        $cart->user_hash = $this->getFromSession('id');
        $cart->color_id = $color_id;
        $cart->save();
        $allCart = (new CartsUtil())->getSelfCart();
        foreach($allCart as $k=> $v) {
            if($v['id'] == $cart->id) {
                $discont = (new SalesUtil())->detectSale($v);
                $cart->total = $cart->total - (($discont && isset($discont['sale_val']))
                    ? $discont['sale_val']
                    : 0 );
                break;
            }
        }
        return ($cart->save()) ? 200 : 400;
    }

}