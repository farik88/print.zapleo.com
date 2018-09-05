<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->productMarkings,
        'key' => 'marking_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'marking.name'
        ],
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_markings','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/markings/' . $model->marking->name,[
                    'style' => 'width:50px;'
                ]);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'markings'
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
