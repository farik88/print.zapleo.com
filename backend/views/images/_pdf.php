<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Images */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Images'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'title',
        'name',
        'ext',
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
        'id',
        [
                'attribute' => 'product.id',
                'label' => 'Product'
            ],
        [
                'attribute' => 'order.id',
                'label' => 'Order'
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
</div>
