<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Images */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
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
<div class="images-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'title',
        'name',
        'ext',
        [
            'label' => Yii::t('backend_images','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/print/' . $model->name.'.'.$model->ext,[
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
if($providerOrderProduct->totalCount){
    $gridColumnOrderProduct = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'product.name',
            'label' => Yii::t('backend_images','Товар')
        ],
        [
            'attribute' => 'order.id',
            'label' => Yii::t('backend_images','Заказ')
        ],
        [
            'attribute' => 'total',
        ],
        [
            'attribute' => 'count',
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOrderProduct,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-order-product']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_images','Заказ и Товар'),
        ],
        'columns' => $gridColumnOrderProduct
    ]);
}
?>
    </div>
</div>
