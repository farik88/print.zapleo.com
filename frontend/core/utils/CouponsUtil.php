<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 22.05.17
 * Time: 16:14
 */

namespace frontend\core\utils;


use common\models\Coupons;
use common\models\OrderCart;

class CouponsUtil extends BaseUtil
{

    public function getCoupon($hash){
        return ($hash)
            ? Coupons::find()->where(['hash'=>$hash,'active'=>Coupons::ACTIVE])->one()
            : null;
    }

    protected function setCouponTo($id) {

    }
    
    protected function detectInterface($type) {
        //todo make as interface
        switch($type) {
            case Coupons::TYPE_PRODUCT :
                return "common\\models\\ProductCoupon";
            case Coupons::TYPE_LABEL :
                return "common\\models\\CouponLabel";
            case Coupons::TYPE_COVER :
                return "common\\models\\CouponCover";
            default :
                return null;
        }
    }




    public function applyCoupon($coupon, $cart) {
        $couponInterface = $this->detectInterface($coupon->type);
        $res = $couponInterface::find()->where(['coupon_id'=>$coupon->id])->one();
        $cup = Coupons::findOne($res->coupon_id);
        $percent = $cup->discount_type == Coupons::TYPE_PERCENT;
        $comparedKey = $couponInterface::comparedKey();
        $changed = 0;
        $salesUtil = new SalesUtil();
        foreach ($cart as $v){
            if($salesUtil->detectSale($v) ||$res->{$comparedKey} != $v[$comparedKey]){
                continue;
            }
            $changed = 1;
            $prodCart = OrderCart::findOne($v['id']);
            $prodCart->total = ($percent)
                ? $prodCart->total - ($prodCart->total*($cup->value/100))
                : $prodCart->total - $cup->value;
            if($prodCart->total < 0) {
                //todo throw error
                return null;
            }
            $prodCart->coupon_id = $res->coupon_id;
            if(!$prodCart->save()){
                //todo throw error
                return null;
            }
        }
        if($changed) {
            $cup->active = Coupons::DISABLED;
            $cup->save();
        }

        return $cup;
//
//
//        if($coupon->type == Coupons::TYPE_PRODUCT){
//            $res = ProductCoupon::find()->where(['coupon_id'=>$coupon->id])->one();
//            $cup = Coupons::findOne($res->coupon_id);
//            foreach ($cart as $v){
//                if($res->cover_id == $v['cover_id']){
//                    if($cup->discount_type == Coupons::TYPE_PERCENT){
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - ($prodCart->total*($cup->value/100));
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }else{
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - $cup->value;
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }
//                }
//            }
//        }elseif ($coupon->type == Coupons::TYPE_LABEL){
//            $res = CouponLabel::find()->where(['coupon_id'=>$coupon->id])->one();
//            $cup = Coupons::findOne($res->coupon_id);
//            foreach ($cart as $v){
//                if($res->cover_id == $v['cover_id']){
//                    if($cup->discount_type == Coupons::TYPE_PERCENT){
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - ($prodCart->total*($cup->value/100));
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }else{
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - $cup->value;
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }
//                }
//            }
//        }elseif ($coupon->type == Coupons::TYPE_COVER){
//            $res = CouponCover::find()->where(['coupon_id'=>$coupon->id])->one();
//            $cup = Coupons::findOne($res->coupon_id);
//            foreach ($cart as $v){
//                if($res->cover_id == $v['cover_id']){
//                    if($cup->discount_type == Coupons::TYPE_PERCENT){
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - ($prodCart->total*($cup->value/100));
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }else{
//                        $prodCart = OrderCart::findOne($v['id']);
//                        $prodCart->total = $prodCart->total - $cup->value;
//                        $prodCart->coupon_id = $res->coupon_id;
//                        if($prodCart->save()){
//                            $cup->active = Coupons::DISABLED;
//                            $cup->save();
//                        }
//                    }
//                }
//            }
//        }

    }
}