<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Users'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'username',
        'auth_key',
        'password_hash',
        'password_reset_token',
        'email:email',
        'status',
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
                'attribute' => 'delivery.id',
                'label' => 'Delivery'
            ],
        [
                'attribute' => 'payment.id',
                'label' => 'Payment'
            ],
        [
                'attribute' => 'coupon.id',
                'label' => 'Coupon'
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
