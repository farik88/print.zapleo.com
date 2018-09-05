<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$appAsset = 'frontend\assets\AppAsset';
$this->title = Yii::t('backend_layouts','Акции');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

$this->registerCssFile('@web/css/sale.css',["depends" => $appAsset]);
$this->registerJsFile('@web/js/sale.js',["depends" => $appAsset]);
?>
<div class="sales-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend_form', 'Расширенный поиск'), '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        ['attribute' => 'id', 'visible' => false],
        'value',
        [
            'attribute'=>'type',
            'value'=> function($model){
                if($model->type == $model::PERCENT){
                    return '%';
                }else if($model->type == $model::CURRENCY){
                    return '₴';
                }
            }
        ],

        'data_start',
        'data_end',

        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function($model){
                if($model->active == 1){
                    return '<label data-sale-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="1" checked>
                              <div class="slider round"></div>
                            </label>';
                }else if($model->active == 0){
                    return '<label data-sale-id="'.$model->id.'" class="switch">
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-sales']],
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
