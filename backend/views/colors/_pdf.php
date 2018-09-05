<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Colors */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colors-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Colors'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

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
        'id',
        [
                'attribute' => 'product.id',
                'label' => 'Product'
            ],
                [
                'attribute' => 'file.id',
                'label' => 'File'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerProductColor,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Product Color'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnProductColor
    ]);
}
?>
    </div>
</div>
