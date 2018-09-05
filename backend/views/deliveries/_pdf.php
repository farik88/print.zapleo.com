<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Deliveries */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deliveries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliveries-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Deliveries'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'title',
        [
                'attribute' => 'file.id',
                'label' => 'File'
            ],
        'comment:ntext',
        'price',
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
if($providerOrders->totalCount){
    $gridColumnOrders = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
                [
                'attribute' => 'payment.id',
                'label' => 'Payment'
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
