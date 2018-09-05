<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Covers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Covers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="covers-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Covers'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'name',
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
        'id',
        [
                'attribute' => 'coupon.id',
                'label' => 'Coupon'
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
if($providerCoverSale->totalCount){
    $gridColumnCoverSale = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
                'attribute' => 'sale.id',
                'label' => 'Sale'
            ],
            ];
    echo Gridview::widget([
        'dataProvider' => $providerCoverSale,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Cover Sale'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnCoverSale
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductCover->totalCount){
    $gridColumnProductCover = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
                'attribute' => 'product.id',
                'label' => 'Product'
            ],
                [
                'attribute' => 'file.id',
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
</div>
