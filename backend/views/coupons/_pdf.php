<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */

$this->title = $model->hash;
$this->params['breadcrumbs'][] = ['label' => 'Coupons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupons-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Coupons'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'hash',
        'value',
        'discount_type',
        'active',
        'type',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerCouponCover->totalCount){
    $gridColumnCouponCover = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'cover.id',
                'label' => 'Cover'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponCover,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Coupon Cover'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnCouponCover
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerCouponLabel->totalCount){
    $gridColumnCouponLabel = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'label.id',
                'label' => 'Label'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponLabel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Coupon Label'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnCouponLabel
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerOrders->totalCount){
    $gridColumnOrders = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'delivery.id',
                'label' => 'Delivery'
            ],
        [
                'attribute' => 'payment.id',
                'label' => 'Payment'
            ],
                [
                'attribute' => 'user.id',
                'label' => 'User'
            ],
        'total',
        'comment:ntext',
        'status_payment',
        'status_delivery',
        'data',
        'address',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrders,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Orders'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnOrders
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductCoupon->totalCount){
    $gridColumnProductCoupon = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'product.id',
                'label' => 'Product'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductCoupon,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Coupon'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnProductCoupon
    ]);
}
?>
    </div>
</div>
