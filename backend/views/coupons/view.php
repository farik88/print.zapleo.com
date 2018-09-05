<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */

$this->title = Yii::t('backend_layouts','Купон') . ' ' . $model->hash;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Купоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 15px">
    <?=
    Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . 'PDF',
        ['pdf', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'target' => '_blank',
            'data-toggle' => 'tooltip',
            'title' => 'Will open the generated PDF file in a new window'
        ]
    )?>

    <?= Html::a(Yii::t('backend_form','Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('backend_form','Удалить'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ])
    ?>
</div>
<div class="coupons-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'hash',
        'value',
        [
            'attribute'=>'discount_type',
            'value'=> function($model){
                if($model->discount_type == $model::TYPE_PERCENT){
                    return '%';
                }else if($model->discount_type == $model::TYPE_CURRENCY){
                    return '₴';
                }
            }
        ],
        [
            'attribute' => 'active',
            'value' => function($model){
                switch ($model->active){
                    case $model::ACTIVE:
                        return Yii::t('backend_coupons','Активно');
                    case $model::DISABLED:
                        return Yii::t('backend_coupons','Не активно');
                    default:
                        return "error";

                }
            },
        ],
        [
            'attribute'=>'type',
            'value'=> function($model){
                if($model->type == $model::TYPE_PRODUCT){
                    return Yii::t('backend_coupons','Продукт');
                }else if($model->type == $model::TYPE_LABEL){
                    return Yii::t('backend_coupons','Марки');
                }else if($model->type == $model::TYPE_COVER){
                    return Yii::t('backend_coupons','Чехлы');
                }
            }
        ],
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
                'attribute' => 'cover.name',
                'label' => Yii::t('backend_coupons','Название')
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponCover,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupon-cover']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Чехлы'),
        ],
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
                'attribute' => 'label.name',
                'label' => Yii::t('backend_coupons','Название')
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponLabel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupon-label']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Марки товаров'),
        ],
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
                'label' => Yii::t('backend_coupons','Доставка')
            ],
            [
                'attribute' => 'payment.id',
                'label' => Yii::t('backend_coupons','Оплата')
            ],
                        [
                'attribute' => 'user.id',
                'label' => Yii::t('backend_coupons','Пользователь')
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-orders']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Заказы'),
        ],
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
                'attribute' => 'product.name',
                'label' => Yii::t('backend_coupons','Название')
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductCoupon,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-coupon']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Товары'),
        ],
        'columns' => $gridColumnProductCoupon
    ]);
}
?>
    </div>
</div>
