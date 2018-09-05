<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Payments */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Методы оплаты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 15px">
    <?= Html::a(Yii::t('backend_form','Обновить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('backend_form','Удалить'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ])
    ?>
</div>
<div class="payments-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        [
            'attribute' => 'active',
            'value' => function($model){
                switch ($model->active){
                    case $model::PAY_ACTIVE:
                        return Yii::t('backend_deliveries','Активно');
                    case $model::PAY_DISABLED:
                        return Yii::t('backend_deliveries','Не активно');
                    default:
                        return "error";

                }
            },
        ],
        'comment:ntext',

        [
            'attribute' => 'file_id',
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,[
                    'style' => 'width:50px;'
                ]);
            },
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerOrders->totalCount){
    $gridColumnOrders = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'delivery.title',
                'label' => Yii::t('backend_deliveries','Доставка')
            ],
                        [
                'attribute' => 'coupon.id',
                'label' => Yii::t('backend_deliveries','Купон')
            ],
            [
                'attribute' => 'user.id',
                'label' => Yii::t('backend_deliveries','Пользователь')
            ],
            'total',
            'comment:ntext',
            'status_payment',
            'status_delivery',
            'data',
            'address',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrders,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-orders']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Заказы'),
        ],
        'columns' => $gridColumnOrders
    ]);
}
?>
    </div>
</div>
