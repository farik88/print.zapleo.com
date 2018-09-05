<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Folders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Folders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folders-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Folders'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'parent_folder',
        'name',
        'type_id',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerResources->totalCount){
    $gridColumnResources = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
                'name',
        'ext',
        'title',
        'type_id',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerResources,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Resources'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnResources
    ]);
}
?>
    </div>
</div>
