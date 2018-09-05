<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Colors */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Цвета'), 'url' => ['index']];
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
<div class="colors-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'name',
        'code',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerProductColor->totalCount){
    $gridColumnProductColor = [
        ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'product.name',
                'label' => Yii::t('backend_colors','Товар')
            ],
            ['attribute' => 'file.id',
                'label' => Yii::t('backend_colors','Фото'),
                            'format' => 'raw',
                'value'=>function($model){
                    if ($model)
                    { return \kartik\helpers\Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,[
                        'style' => 'width:100px;'
                    ]);}
                    else
                    {return NULL;}
                }

            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductColor,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product-color']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_colors','Товары цвета'),
        ],
        'columns' => $gridColumnProductColor
    ]);
}
?>
    </div>
</div>
