<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->productColors,
        'key' => 'color_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'color.name'
        ],
        [
            'attribute' => 'color.code'
        ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_colors','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                 return Html::img(Yii::getAlias('@buploads').'/colors/' . $model->file->title,[
                     'style' => 'width:50px;'
                 ]);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'colors'
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
