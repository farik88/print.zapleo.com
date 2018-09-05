<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DeliveriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use yii\helpers\Url;
$this->title = Yii::t('backend_layouts', 'Методы доставки');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

$appAsset = 'frontend\assets\AppAsset';

$this->registerCssFile('@web/css/delivery.css',["depends" => $appAsset]);
$this->registerJsFile('@web/js/delivery.js',["depends" => $appAsset]);
?>
<div class="deliveries-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
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
       // 'id',
        'title',

        [
            'attribute' => 'file_id',
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            },

        ],
        [
            'attribute' => 'comment',
            'value' => function($model){
                if(strlen($model->comment)>50){
                    $model->comment = substr($model->comment, 0, 50);
                    return $model->comment.'...';
                }
                return $model->comment;
            },
        ],
        'price',
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function($model){
                if($model->active == $model::DEL_ACTIVE){
                    return '<label data-del-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="1" checked>
                              <div class="slider round"></div>
                            </label>';
                }else if($model->active == $model::DEL_DISABLED){
                    return '<label data-del-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="0">
                              <div class="slider round"></div>
                            </label>';
                }
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ];
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-deliveries']],
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
