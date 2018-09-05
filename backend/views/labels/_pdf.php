<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Labels */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Labels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labels-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Labels'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
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
if($providerCouponLabel->totalCount){
    $gridColumnCouponLabel = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'coupon.id',
                'label' => 'Coupon'
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
if($providerLabelSale->totalCount){
    $gridColumnLabelSale = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'sale.id',
                'label' => 'Sale'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerLabelSale,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Label Sale'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnLabelSale
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
                'attribute' => 'product.name',
                'label' => 'Product'
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
</div>
