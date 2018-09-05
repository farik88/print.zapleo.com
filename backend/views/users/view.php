<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = Yii::t('backend_users','Пользователь').': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 15px">
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
<div class="users-view" style="padding-left: 15px; padding-right: 15px;">

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
            'value' => function($model){
                return date('d.m.y',$model->created_at);
            },
        ],
        [
            'attribute' => 'last_active',
            'value' => function($model){
                return $model->last_active;
            },
        ],

        [
            'attribute' => 'updated_at',
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
        ],
        [
            'attribute' => 'payment.title',
        ],
        [
            'attribute' => 'coupon.hash',
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
                        return Yii::t('backend_orders','Оплачено');
                    case $model::PAYMENT_EXPECTATION:
                        return Yii::t('backend_orders','Ожидание оплаты');
                    case $model::PAYMENT_ERROR:
                        return Yii::t('backend_orders','Ошибка');
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
                        return Yii::t('backend_orders','Доставлено');
                    case $model::DELIVERY_ON_MY_WAY:
                        return Yii::t('backend_orders','Отправлено');
                    case $model::DELIVERY_EXPECTATION:
                        return Yii::t('backend_orders','Ожидание отправки');
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
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Заказы'),
        ],
        'columns' => $gridColumnOrders
    ]);
}
?>
    </div>
</div>
