<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->productCovers,
        'key' => 'cover_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'cover.name'
        ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_covers','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/covers/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
        [
            'attribute' => 'color.name'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'covers'
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
