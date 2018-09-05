<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->orders,
        'key' => 'id'
    ]);
    $gridColumns = [
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
