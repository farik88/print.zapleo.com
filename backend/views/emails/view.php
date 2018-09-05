<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Пользователь:'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
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
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
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
        [
            'attribute' => 'created_at',
            'label' => 'Создание',
            'value' => function($model){
                return date('d.m.y',$model->created_at);
            },
        ],
        [
            'attribute' => 'last_active',
            'label' => 'Последняя активность',
            'value' => function($model){
                return $model->last_active;
            },
        ],

        [
            'attribute' => 'updated_at',
            'label' => 'Обновление',
            'value' => function($model){
                return date('d.m.y',$model->updated_at);
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
if($providerOrders->totalCount){
    $gridColumnOrders = [
        ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'delivery.title',
                'label' => 'Доставка'
            ],
            [
                'attribute' => 'payment.title',
                'label' => 'Оплата'
            ],
            [
                'attribute' => 'coupon.hash',
                'label' => 'Купон',
            ],

                        'total',
                [
            'attribute' => 'comment',
            'value' => function($model){
                if(strlen($model->comment)>25){
                    $model->comment = substr($model->comment, 0, 25);
                    return $model->comment.'...';
                }
                return $model->comment;
            },

        ],
        [
            'attribute' => 'status_payment',
            'value' => function($model){
                switch ($model->status_payment){
                    case $model::PAYMENT_ACCEPTED:
                        return 'Оплачено';
                    case $model::PAYMENT_EXPECTATION:
                        return 'Ожидание оплаты';
                    case $model::PAYMENT_ERROR:
                        return 'Ошибка';
                    default:
                        return "error";

                }
            },
        ],
        [
            'attribute' => 'status_delivery',
            'value' => function($model){
                switch ($model->status_delivery){
                    case $model::DELIVERY_ACCEPTED:
                        return 'Доставлено';
                    case $model::DELIVERY_ON_MY_WAY:
                        return 'Отправлено';
                    case $model::DELIVERY_EXPECTATION:
                        return 'Ожидание отправки';
                    default:
                        return "error";
                }
            },
        ],
            'data',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrders,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-orders']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Orders'),
        ],
        'columns' => $gridColumnOrders
    ]);
}
?>
    </div>
</div>
