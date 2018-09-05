<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;


$this->params['breadcrumbs'][] = $this->title;
$this->title = Yii::t('backend_layouts','Шрифты');
?>
<div class="folders-index">

    <?php
    echo \kartik\file\FileInput::widget([
        'name' => 'file',
        'language' => \Yii::$app->controller->current_lang->url,
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['folders/load-resources-fonts']),
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, previewId, index) {
                location.reload();
                }'
        ]

    ]);
    ?>
    <br>

<?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
//        [
//            'class' => 'kartik\grid\ExpandRowColumn',
//            'width' => '50px',
//            'value' => function ($model, $key, $index, $column) {
//                return GridView::ROW_COLLAPSED;
//            },
//            'detail' => function ($model, $key, $index, $column) {
//                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
//            },
//            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'expandOneOnly' => true
//        ],
        //'id',
        //'parent_folder',


        'title',
        'name',
        'ext',
        //'type_id',
//        [
//                'attribute' => 'type_id',
//                'value' => function($model){
//                    switch ($model->type_id){
//                        case $model::TYPE_EMOJI:
//                            return 'Emoji';
//                        case $model::TYPE_FONTS:
//                            return 'Шрифты';
//                        case $model::PAYMENT_ERROR:
//                            return 'Фоны';
//                        default:
//                            return "error";
//
//                    }
//                }
//        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}'
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-folders']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
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
            ]) ,
        ],
    ]); ?>

</div>
