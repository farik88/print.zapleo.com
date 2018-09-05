<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Payments */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Payments'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'active',
        'comment:ntext',
        [
                'attribute' => 'file.title',
                'label' => 'File'
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
if($providerOrders->totalCount){
    $gridColumnOrders = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'delivery.title',
                'label' => 'Delivery'
            ],
                [
                'attribute' => 'coupon.id',
                'label' => 'Coupon'
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
</div>
