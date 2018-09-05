<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Заказ№'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        [
            'attribute' => 'id',
            'label' => 'Номер заказа'
        ],
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
                'label' => 'Купон'
            ],
        [
                'attribute' => 'user.username',
                'label' => 'Пользователь'
            ],
        'total',
        'comment:ntext',
        [
            'attribute' => 'status_payment',
            'value' => function($model){
                switch ($model->status_payment){
                    case $model::PAYMENT_ACCEPTED:
                        return 'Оплачено';
                    case $model::PAYMENT_EXPECTATION:
                        return 'Ожидание оплаты';
                    case $model::PAYMENT_ERROR:
                        return 'Ошибка оплаты';
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
                'attribute' => 'product.name',
                'label' => 'Товар'
            ],
        [
            'label' => 'Фото',
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/print/' . $model->image->name.'.'.$model->image->ext,[
                    'style' => 'width:50px;'
                ]);
            },
        ],
        'total',
        'count',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrderProduct,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Изображение для печати   '),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnOrderProduct
    ]);
}
?>
    </div>
</div>
