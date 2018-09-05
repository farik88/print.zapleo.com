<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 24.05.17
 * Time: 13:35
 */

namespace frontend\core\utils;
use common\models\Files;
use common\models\OrderCart;
use common\models\Orders;
use common\models\ProductColor;
use common\models\ProductCover;
use common\models\UserAddress;
use common\models\Users;
use yii;

class ProfilesUtil extends BaseUtil
{

    protected function getCart($orderId) {
        return OrderCart::find()->with('image','product','cover','order')->where(['order_id'=>$orderId])->asArray()->all();
    }

    /**
     * @param $id
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getOrderByUser($id) {
        return Orders::find()
            ->where([ 'user_id' => $id ])
            ->asArray()
            ->all();
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function getSelfOrder() {
        return $this->getOrderByUser($this->getUserId());
    }

    
    public function getProfile(){

        $order = $this->getSelfOrder();
        $order_prod = [];
        for ($i = 0, $c_order = count($order); $i < $c_order; $i++) {
            $cart = $this->getCart($order[$i]['id']);
            foreach ($cart as $key => &$val){
                $file_id = ProductCover::find()->select('file_id')->where(['product_id'=>$val['product_id'],'cover_id'=>$val['cover_id'],'color_id'=>$val['color_id']])->asArray()->one();
                $cover_color = Files::find()->where(['id'=>$file_id])->asArray()->one();
                $val['producrt_cover_color_file_id'] = $cover_color;
                $prod_file_id = ProductColor::find()->select('file_id')->where(['product_id'=>$val['product_id'],'color_id'=>$val['color_id']])->asArray()->one();
                $product_color = Files::find()->where(['id'=>$prod_file_id])->asArray()->one();
                $val['producrt_color_file_id'] = $product_color;
            }
            $order_prod[] = $cart;
        }

        /**
         * @todo sql запрос
         */
        $command = Yii::$app->db->createCommand("SELECT sum(total) FROM orders WHERE orders.user_id = :id_user AND orders.status_payment = :status_payment", [':id_user' => $this->getUserId(),':status_payment'=>Orders::PAYMENT_ACCEPTED]);
        $sum = $command->queryScalar();
        $address = UserAddress::find()->where(['user_id'=>$this->getUserId()])->asArray()->all();
        $model = Users::findOne($this->getUserId());
        return compact('address', 'sum', 'order_prod', 'order', 'c_order', 'model' );
    }

    /**
     * @param $id
     * @param $value
     * @return bool
     */
    public function setUserAddress($id, $value) {
        $address = UserAddress::findOne($id);
        $address->address = $value;
        //todo checkout to user permission
        return $address->save();
    }

    /**
     * @param $address
     * @return bool
     */
    public function addSelfAddress($address) {
        $addressRecord = new UserAddress();
        $addressRecord->address = $address;
        $addressRecord->user_id = $this->getUserId();
        return $addressRecord->save();
    }

    /**
     * @param $info
     * @return bool
     */
    public function setUserInfo($info) {        
        $user = Users::findOne($this->getUserId());
        $user->load($info, '');
        return $user->save();
    }
}