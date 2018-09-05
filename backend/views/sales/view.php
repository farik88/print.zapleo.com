<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Sales */
$type = ($model->type == $model::PERCENT) ? '%' : '₴';
$this->title = Yii::t('backend_sales','Акция') . ' '. $model->value.' '.$type;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Акции'), 'url' => ['index']];
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
<div class="sales-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'value',
        'data_start',
        'data_end',

        [
            'attribute'=>'type',
            'value' => function($model){
                $type = ($model->type == $model::PERCENT) ? '%' : '₴';
                return $type;
            },
        ],
        [
            'attribute'=>'active',
            'value' => function($model){
                $type = ($model->active == 1) ? Yii::t('backend_sales','Активно') : Yii::t('backend_sales','Не активно');
                return $type;
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
if($providerCoverSale->totalCount){
    $gridColumnCoverSale = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'cover.name',
                'label' => Yii::t('backend_sales','Чехол')
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCoverSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-cover-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Чехлы'),
        ],
        'columns' => $gridColumnCoverSale
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
                'attribute' => 'label.name',
                'label' => Yii::t('backend_sales','Метка')
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerLabelSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-label-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Марки товаров'),
        ],
        'columns' => $gridColumnLabelSale
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProductSale->totalCount){
    $gridColumnProductSale = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'product.name',
                'label' => Yii::t('backend_sales','Товар')
            ],
                ];
    echo Gridview::widget([
        'dataProvider' => $providerProductSale,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-sale']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_layouts','Товары'),
        ],
        'columns' => $gridColumnProductSale
    ]);
}
?>
    </div>
</div>
