<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->productCoupons,
        'key' => 'coupon_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'coupon.id',
            'label' => Yii::t('backend_coupons','Купон'),
            'value'=>function($model){
                $type = ($model->coupon->type == \backend\models\Coupons::TYPE_PERCENT) ? '%' : '₴';
                return $model->coupon->value.' '.$type;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'coupons'
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
