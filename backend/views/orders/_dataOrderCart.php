<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->orderCarts,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'orders',
            'template' => '{image}{download}',
            'buttons'=>[
                'image' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $url,['class'=>'btn btn-app', 'target'=>'_blank','data-pjax' => '0',]);
                },
                'download' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-download"></span>', $url,['class'=>'btn btn-app', 'data-pjax' => '0',]);
                },
            ],
        ],
        [
            'attribute' => 'product.name',
            'label' => Yii::t('backend_orders','Товар')
        ],
        [
            //'attribute' => 'file_id',
            'label' => Yii::t('backend_orders','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return \yii\bootstrap\Html::img(Yii::getAlias('@buploads').'/print/' . $model->image->name .'.'.$model->image->ext,[
                    'style' => 'width:50px;'
                ]);
            },
        ],
        'total',
        'count',
        [
            'attribute' => 'cover.title',
            'label' => Yii::t('backend_orders','Чехол')
        ],
//        'user_hash',
        [
            'attribute' => 'color.name',
            'label' => Yii::t('backend_orders','Цвет')
        ],
//        'user_id',
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
