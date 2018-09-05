<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 17.05.17
 * Time: 10:02
 */

namespace frontend\core\utils;

use backend\models\Orders;
use common\models\Users;
use yii;

class OrdersUtil extends BaseUtil
{
    /**
     * @param $user
     * @return bool
     */
    protected function sendForUser($user, $order) {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'paymentUser-html', 'text' => 'paymentUser-text'],
                ['user' => $user, 'order' => $order]
            )
            ->setFrom([ Yii::$app->confs->get('supportEmail') => Yii::$app->name . ' (автоматически)'])
            ->setTo($user->email)
            ->setSubject('Вы успешно оплатили заказ в ' . Yii::$app->name)
            ->attach($this->getPdf($order->id))
            ->send();
    }


    protected function getPdf($orderId) {
// Create the attachment with your data
        return Yii::getAlias('@backurl'). '/orders/pdf?id='.$orderId;
    }
    /**
     * @param $order Orders
     * @return bool
     */
    protected function sendForAdmin($order) {
        $adminEmail = Yii::$app->confs->get('supportEmail');
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'paymentAdmin-html', 'text' => 'paymentAdmin-text'],
                ['order' => $order]
            )
            ->setFrom([$adminEmail=> Yii::$app->name . ' (автоматически)'])
            ->setTo($adminEmail)
            ->setSubject('Оплачен заказ № ' . $order->id)
            ->send();
    }

    
    public function successPayment($order) {
        echo '1';
        if(!$order) {
            //todo throw
            return;
        }
        $userId = $order['user_id'];
        $user = Users::find()->where(['id' => $userId])->one();
        $this->sendForUser($user, $order);
        $this->sendForAdmin($order);

    }
    /**
     * @param $cart
     * @return mixed
     */
    public function searchProductAndColor($cart){
        for ($i = 0 ; $i<count($cart); $i++){
            $file_id = \common\models\ProductCover::find()->select('file_id')->where(['product_id'=>$cart[$i]['product_id'],'cover_id'=>$cart[$i]['cover_id'],'color_id'=>$cart[$i]['color_id']])->asArray()->one();
            $cover_color = \common\models\Files::find()->where(['id'=>$file_id])->asArray()->one();
            $cart[$i]['producrt_cover_color_file_id'] = $cover_color;

            $prod_file_id = \common\models\ProductColor::find()->select('file_id')->where(['product_id'=>$cart[$i]['product_id'],'color_id'=>$cart[$i]['color_id']])->asArray()->one();
            $product_color = \common\models\Files::find()->where(['id'=>$prod_file_id])->asArray()->one();
            $cart[$i]['producrt_color_file_id'] = $product_color;
        }

        return $cart;
    }
}