<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 22.05.17
 * Time: 16:05
 */

namespace frontend\core\utils;


use common\models\OrderCart;
use common\traits\SessionTrait;

/**
 * Class CartsUtil
 * @package frontend\core\utils
 */
class CartsUtil extends BaseUtil
{
    use SessionTrait;

    /**
     * @param $userId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCart($userId) {
        $userHash = $this->getFromSession('id');
        return OrderCart::find()
            ->with('image','product','product.productLabels', 'product.productLabels',
                'product.productLabels.label', 'product.productLabels.label.labelSales',
                'product.productLabels.label.labelSales.activeSale',
                'product.productSales','product.productSales.activeSale','cover.coverSales.activeSale','coupon')
            ->where("order_id is null and (user_id=:user_id or user_hash=:user_hash)", [
                ':user_id'=>$userId,
                ':user_hash'=> $userHash
            ])
            ->asArray()
            ->all();
    }

    public function getSelfCart() {
        return $this->getCart($this->getUserId());
    }
}