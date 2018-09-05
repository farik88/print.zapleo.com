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
                'label' => Yii::t('backend_orders','Доставка')
            ],
        [
                'attribute' => 'payment.title',
                'label' => Yii::t('backend_orders','Оплата')
            ],
        [
                'attribute' => 'coupon.hash',
                'label' => Yii::t('backend_orders','Купон'),
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
