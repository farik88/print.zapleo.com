<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->resources,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'name',
        'ext',
        'title',
        //'type_id',
        [
            'attribute' => 'file.name',
            'label' => Yii::t('backend_folders','Изображение'),
            'format' => 'raw',
            'value'=> function($model){
                $folder = \backend\models\base\Folders::findOne($model->folder_id);
                if($folder->type_id == 2){
                    return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/resources/background/'.$folder->name.'/' . $model->title,[
                        'style' => 'width:50px;'
                    ]);
                }else if($folder->type_id == 0){
                    return \yii\helpers\Html::img(Yii::getAlias('@buploads').'/resources/emoji/'.$folder->name.'/' . $model->title,[
                        'style' => 'width:50px;'
                    ]);
                }

            }
        ],
//        [
//            'class' => 'yii\grid\ActionColumn',
//            'controller' => 'resources',
//        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'resources',
            'template'=>'{view} {update} {delete}',
            'buttons'=>[
                'delete' => function ($url, $model) {
                    return \yii\bootstrap\Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('backend_form', 'Удалить'),
                        'data-method'=>"post",
                    ]);

                }
            ]

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
