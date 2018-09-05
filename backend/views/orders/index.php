<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Заказы');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="orders-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend_form', 'Расширенный поиск'), '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
       // ['class' => 'yii\grid\SerialColumn'],
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
        'id',
        [
            'attribute' => 'delivery_id',
            'value' => function($model){
                return $model->delivery->title;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveries::find()->asArray()->all(), 'id', 'title'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['id' => 'grid-orders-search-delivery_id']
        ],
        [
            'attribute' => 'address',
            'value' => function($model){
                if(strlen($model->address)>15){
                    $model->address = substr($model->address, 0, 15);
                    return $model->address.'...';
                }
                return $model->address;
            },
        ],
        [
            'attribute' => 'user_id',
            'value' => function($model){
                return $model->user->username;
            },
            //'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\backend\models\Users::find()->asArray()->all(), 'id', 'username'),
            //            'filterWidgetOptions' => [
            //                'pluginOptions' => ['allowClear' => true],
            //            ],
            //'filterInputOptions' => ['placeholder' => 'Пользователи', 'id' => 'grid-orders-search-user_id']
        ],
        'total',
        [
            'attribute' => 'payment_id',
            'value' => function($model){
                if($model->payment){
                    return $model->payment->title;
                }else{
                    return NULL;
                }
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\backend\models\Payments::find()->asArray()->all(), 'id', 'title'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Оплата', 'id' => 'grid-orders-search-payment_id']
        ],

        [
            'attribute' => 'status_payment',
            'value' => function($model){
                switch ($model->status_payment){
                    case $model::PAYMENT_ACCEPTED:
                       return Yii::t('backend_orders','Оплачено');
                    case $model::PAYMENT_EXPECTATION:
                        return Yii::t('backend_orders','Ожидание оплаты');
                    case $model::PAYMENT_ERROR:
                        return Yii::t('backend_orders','Ошибка');
                    default:
                        return "error";

                }
            },
        ],
        [
            'attribute' => 'status_delivery',
            'value' => function($model){
                switch ($model->status_delivery){
                    case $model::DELIVERY_ACCEPTED:
                        return Yii::t('backend_orders','Доставлено');
                    case $model::DELIVERY_ON_MY_WAY:
                        return Yii::t('backend_orders','Отправлено');
                    case $model::DELIVERY_EXPECTATION:
                        return Yii::t('backend_orders','Ожидание отправки');
                    default:
                        return "error";
                }
            },
        ],

        'data',
        [
            'attribute' => 'coupon_id',
            'value' => function($model){
                if ($model->coupon) {
                    $type = ($model->coupon->type == 0) ? '%' : '₴';
                    return $model->coupon->value.''.$type;
                }else{
                    return NULL;
                }
            },

        ],
//        [
//            'attribute' => 'comment',
//            'value' => function($model){
//                if(strlen($model->comment)>50){
//                    $model->comment = substr($model->comment, 0, 50);
//                    return $model->comment.'...';
//                }
//                return $model->comment;
//            },
//
//        ],

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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-orders']],
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
