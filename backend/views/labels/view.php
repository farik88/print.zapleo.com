<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Labels */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Labels', 'url' => ['index']];
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
<div class="labels-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerCouponLabel->totalCount){
    $gridColumnCouponLabel = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'coupon_id',
            'label' => Yii::t('backend_labels','Купон'),
            'value' => function($model){
                if ($model->coupon) {
                    $type = ($model->coupon->type == 0) ? '%' : 'грн';
                    return $model->coupon->value.''.$type;
                }else{
                    return NULL;
                }
            },

        ],
        ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponLabel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupon-label']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Купоны'),
        ],
        'columns' => $gridColumnCouponLabel
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerLabelSale->totalCount){
    $gridColumnLabelSale = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'sale_id',
            'label' => Yii::t('backend_labels','Скидка'),
            'value' => function($model){
                if ($model->sale) {
                    $type = ($model->sale->type == 1) ? '%' : '₴';
                    return $model->sale->value.''.$type;
                }else{
                    return NULL;
                }
            },

        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerLabelSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-label-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_products','Скидки'),
        ],
        'columns' => $gridColumnLabelSale
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductLabel->totalCount){
    $gridColumnProductLabel = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'product.name',
                'label' => Yii::t('backend_layouts','Товар')
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerProductLabel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-label']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Товары'),
        ],
        'columns' => $gridColumnProductLabel
    ]);
}
?>
    </div>
</div>
