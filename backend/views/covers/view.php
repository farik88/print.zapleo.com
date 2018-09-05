<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Covers */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Чехлы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 15px">

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
<div class="covers-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'title',
        [
            'label' => Yii::t('backend_covers','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            },
        ],
        [
            'attribute' => 'active',
            'value' => function($model){
                switch ($model->active){
                    case $model::COVER_ACTIVE:
                        return Yii::t('backend_covers','Активно');
                    case $model::COVER_DISABLED:
                        return Yii::t('backend_covers','Не активно');
                    default:
                        return "error";

                }
            },
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
                'attribute' => 'coupon.id',
                'label' => Yii::t('backend_covers', 'Купон')
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponCover,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupon-cover']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Купоны'),
        ],
        'export' => false,
        'columns' => $gridColumnCouponCover
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerCoverSale->totalCount){
    $gridColumnCoverSale = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'sale.id',
                'label' => Yii::t('backend_covers', 'Скидка'),
                'value'=> function($model){
                    $type = ($model->sale->type == \backend\models\Sales::CURRENCY) ? '₴' : '%';
                    return $model->sale->value.' '.$type;
                },
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerCoverSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-cover-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Скидки'),
        ],
        'export' => false,
        'columns' => $gridColumnCoverSale
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
//if($providerProductCover->totalCount){
//    $gridColumnProductCover = [
//        ['class' => 'yii\grid\SerialColumn'],
//            ['attribute' => 'id', 'visible' => false],
//            [
//                'attribute' => 'product.name',
//                'label' => 'Product'
//            ],
//                        [
//                'attribute' => 'file.name',
//                'label' => 'File'
//            ],
//    ];
//    echo Gridview::widget([
//        'dataProvider' => $providerProductCover,
//        'pjax' => true,
//        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-cover']],
//        'panel' => [
//            'type' => GridView::TYPE_PRIMARY,
//            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Product Cover'),
//        ],
//        'export' => false,
//        'columns' => $gridColumnProductCover
//    ]);
//}
?>
    </div>
</div>
