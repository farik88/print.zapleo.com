<?php

    use yii\helpers\Html;
    use kartik\grid\GridView;
    use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->messages,
        'key' => function($model){
            return ['id' => $model->id, 'language' => $model->language];
        }
    ]);
    $gridColumns = [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'translation',
            'label' => Yii::t('backend_source-messages', 'Перевод')
        ],
        [
            'attribute' => 'language',
            'label' => Yii::t('backend_source-messages', 'Язык'),
            'value' => function ($model) {
                return $model->languageInfo->title;
            }
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
?>
    
<?= Html::a(Yii::t('backend_source-messages', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>