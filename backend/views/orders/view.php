<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = Yii::t('backend_layouts','Заказ').' #'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Заказы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 15px">
    <?=
    Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . 'PDF',
        ['pdf', 'id' => $model->id],
        [
            'class' => 'btn btn-danger',
            'target' => '_blank',
            'data-toggle' => 'tooltip',
            'title' => 'Will open the generated PDF file in a new window'
        ]
    )?>

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
<div class="orders-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php
    $gridColumn = [
        'id',
        [
            'attribute' => 'delivery.title',
            'label' => Yii::t('backend_orders','Доставка'),
        ],
        'address',
        [
            'attribute' => 'payment.title',
            'label' => Yii::t('backend_orders','Оплата'),
        ],
        [
            'attribute' => 'coupon.id',
            'label' => Yii::t('backend_orders','Купон'),
            'value'=> function($model){
                if($model->coupon){
                    $type = ($model->coupon->type==0) ? '%' : '₴';
                    return $model->coupon->value.' '.$type;
                }else{
                    return NULL;
                }

            }
        ],
        [
            'attribute' => 'user.username',
            'label' => Yii::t('backend_orders','Пользователь'),
        ],
        [
            'attribute' => 'user.email',
            'label' => Yii::t('backend_orders','Email пользователя'),
        ],
        'total',
        'comment:ntext',
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
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>

    <div class="row">
<?php
if($providerOrderProduct->totalCount){
    $gridColumnOrderProduct = [
        ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'product.name',
                'label' => Yii::t('backend_orders','Товар')
            ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'orders',
            'template' => '{image}{download}',
            'buttons'=>[
                'image' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>',Yii::getAlias('@backurl') . '/orders/image/'.$model->id,['class'=>'btn btn-app', 'target'=>'_blank','data-pjax' => '0',]);
                },
                'download' => function ($url, $model, $key) {
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-download"></span>', Yii::getAlias('@backurl') . '/orders/download/'.$model->id,['class'=>'btn btn-app', 'data-pjax' => '0',]);
                },
            ],
        ],
        [
            'label' => Yii::t('backend_orders','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/print/' . $model->image->name.'.'.$model->image->ext,[
                    'style' => 'width:50px;'
                ]);
            },
        ],
        [
            'attribute' => 'total'
        ],
        [
            'attribute' =>'count'
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrderProduct,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-order-product']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_orders','Товары в заказе'),
        ],
        'columns' => $gridColumnOrderProduct
    ]);
}
?>
    </div>
</div>
