<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Products'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'price',
        [
                'attribute' => 'file.name',
                'label' => 'File'
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
if($providerOrderProduct->totalCount){
    $gridColumnOrderProduct = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'order.id',
                'label' => 'Order'
            ],
        [
                'attribute' => 'image.name',
                'label' => 'Image'
            ],
        'total',
        'count',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrderProduct,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Order Product'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnOrderProduct
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductColor->totalCount){
    $gridColumnProductColor = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'color.name',
                'label' => 'Color'
            ],
        [
                'attribute' => 'file.name',
                'label' => 'File'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductColor,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Color'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
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
                'label' => 'Coupon'
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
    
    <div class="row">
<?php
if($providerProductCover->totalCount){
    $gridColumnProductCover = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'cover.name',
                'label' => 'Cover'
            ],
        [
                'attribute' => 'file.name',
                'label' => 'File'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductCover,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Cover'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
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
                'attribute' => 'label.name',
                'label' => 'Label'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductLabel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Label'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
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
                'attribute' => 'marking.name',
                'label' => 'Marking'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductMarking,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Marking'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
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
                'label' => 'Sale'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductSale,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Sale'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnProductSale
    ]);
}
?>
    </div>
</div>
