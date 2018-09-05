<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Переводы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-message-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
                'attribute' => 'id',
                'label' => Yii::t('backend_translations', 'Исходное сообщение'),
                'value' => function($model){                   
                    return $model->id0->message;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\SourceLangMessage::find()->asArray()->all(), 'id', 'id'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Source message', 'id' => 'grid--id']
            ],
        'language',
        'translation:ntext',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return '<a href="/translation/view?id='.$model->id.'&language='.$model->language.'" title="View" aria-label="View" data-pjax="0">'.
                        '<span class="glyphicon glyphicon-eye-open"></span></a>';
                },
                'update' => function ($url, $model) {
                    return '<a href="/translation/update?id='.$model->id.'&language='.$model->language.'" title="Update" aria-label="Update" data-pjax="0">'.
                        '<span class="glyphicon glyphicon-pencil"></span></a>';
                },
                'delete' => function ($url, $model) {
                    return '<a href="/translation/delete?id='.$model->id.'&language='.$model->language.'" title="Delete" aria-label="Delete" data-pjax="0" data-confirm="Are you sure you want to delete this item?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                }
            ],
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-lang-message']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => false
                ]
            ]) ,
        ],
    ]); ?>

</div>
