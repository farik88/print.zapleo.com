<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Sales */

$this->title = $model->value;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Sales'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'value',
        'data_start',
        'data_end',
        'type',
        'active',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerCoverSale->totalCount){
    $gridColumnCoverSale = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'cover.id',
                'label' => 'Cover'
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
if($providerLabelSale->totalCount){
    $gridColumnLabelSale = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'label.id',
                'label' => 'Label'
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
if($providerProductSale->totalCount){
    $gridColumnProductSale = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'product.id',
                'label' => 'Product'
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
