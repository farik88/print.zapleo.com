<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->orders,
        'key' => 'id'
    ]);
    $gridColumns = [
        //['class' => 'yii\grid\SerialColumn'],
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
                if(strlen($model->comment)>50){
                    $model->comment = substr($model->comment, 0, 50);
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
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'orders'
        ],
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'beforeHeader' => [
            [
                'options' => ['class' => 'skip-export']
            ]
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => false,
        'persistResize' => false,
    ]);
