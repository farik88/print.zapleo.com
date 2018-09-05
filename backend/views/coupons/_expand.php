<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
    [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Coupons'),
        'content' => $this->render('_detail', [
            'model' => $model,
        ]),
    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Coupon Cover'),
        'content' => $this->render('_dataCouponCover', [
            'model' => $model,
            'row' => $model->couponCovers,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Coupon Label'),
        'content' => $this->render('_dataCouponLabel', [
            'model' => $model,
            'row' => $model->couponLabels,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Orders'),
        'content' => $this->render('_dataOrders', [
            'model' => $model,
            'row' => $model->orders,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Product Coupon'),
        'content' => $this->render('_dataProductCoupon', [
            'model' => $model,
            'row' => $model->productCoupons,
        ]),
    ],
    ];
echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'class' => 'tes',
    'pluginOptions' => [
        'bordered' => true,
        'sideways' => true,
        'enableCache' => false
    ],
]);
?>
