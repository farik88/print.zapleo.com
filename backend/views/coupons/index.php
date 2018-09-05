<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CouponsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Купоны');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

$appAsset = 'frontend\assets\AppAsset';

$this->registerCssFile('@web/css/delivery.css',["depends" => $appAsset]);
$this->registerJsFile('@web/js/coupons.js',["depends" => $appAsset]);
?>
<div class="coupons-index">

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
        ['attribute' => 'id', 'visible' => false],
        'hash',
        'value',
        [
            'attribute'=>'discount_type',
            'value'=> function($model){
                if($model->discount_type == $model::TYPE_PERCENT){
                    return '%';
                }else if($model->discount_type == $model::TYPE_CURRENCY){
                    return '₴';
                }
            }
        ],
        [
            'attribute'=>'type',
            'value'=> function($model){
                if($model->type == $model::TYPE_PRODUCT){
                    return Yii::t('backend_coupons','Продукт');
                }else if($model->type == $model::TYPE_LABEL){
                    return Yii::t('backend_coupons','Марки');
                }else if($model->type == $model::TYPE_COVER){
                    return Yii::t('backend_coupons','Чехлы');
                }
            }
        ],
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function($model){
                if($model->active == $model::ACTIVE){
                    return '<label data-coupon-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="1" checked>
                              <div class="slider round"></div>
                            </label>';
                }else if($model->active == $model::DISABLED){
                    return '<label data-coupon-id="'.$model->id.'" class="switch">
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
//        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupons']],
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
