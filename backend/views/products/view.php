<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Товары'), 'url' => ['index']];
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
<div class="products-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'price',
        [
            'attribute' => 'file_id',
            'format' => 'raw',
            'value'=> function($model){
                return Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
        'wspace_width',
        'wspace_height',
        'wspace_width3d',
        'wspace_height3d',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
//if($providerOrderProduct->totalCount){
//    $gridColumnOrderProduct = [
//        ['class' => 'yii\grid\SerialColumn'],
//            ['attribute' => 'id', 'visible' => false],
//                        [
//                'attribute' => 'order.id',
//                'label' => 'Order'
//            ],
//            [
//                'attribute' => 'image.name',
//                'label' => 'Image'
//            ],
//            'total',
//            'count',
//    ];
//    echo Gridview::widget([
//        'dataProvider' => $providerOrderProduct,
//        'pjax' => true,
//        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-order-product']],
//        'panel' => [
//            'type' => GridView::TYPE_PRIMARY,
//            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Order Product'),
//        ],
//        'columns' => $gridColumnOrderProduct
//    ]);
//}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductColor->totalCount){
    $gridColumnProductColor = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'color.name'
        ],
        [
            'attribute' => 'color.code'
        ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_colors','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                return Html::img(Yii::getAlias('@buploads').'/colors/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductColor,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-color']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Цвета'),
        ],
        'columns' => $gridColumnProductColor
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
            'attribute' => 'coupon.id',
            'label' => Yii::t('backend_coupons','Купон'),
            'value'=>function($model){
                $type = ($model->coupon->type == \backend\models\Coupons::TYPE_PERCENT) ? '%' : '₴';
                return $model->coupon->value.' '.$type;
            }
        ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerProductCoupon,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-coupon']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Купоны'),
        ],
        'columns' => $gridColumnProductCoupon
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductCover->totalCount){
    $gridColumnProductCover = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'cover.name'
            ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_covers','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/covers/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductCover,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-cover']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products', 'Чехлы'),
        ],
        'columns' => $gridColumnProductCover
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductLabel->totalCount){
    $gridColumnProductLabel = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'label.name'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductLabel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-label']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Марки'),
        ],
        'columns' => $gridColumnProductLabel
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductMarking->totalCount){
    $gridColumnProductMarking = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'marking.name'
        ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_markings','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/markings/' . $model->marking->name,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductMarking,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-marking']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Разметки'),
        ],
        'columns' => $gridColumnProductMarking
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductSale->totalCount){
    $gridColumnProductSale = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'sale.id',
            Yii::t('backend_sales','Скидка'),
            'value'=>function($model){
                $type = ($model->sale->type == \backend\models\base\Sales::PERCENT) ? '%' : '₴';
                return $model->sale->value.' '.$type;
            }

        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Скидки'),
        ],
        'columns' => $gridColumnProductSale
    ]);
}
?>
    </div>
</div>
