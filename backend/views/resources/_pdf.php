<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Resources */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resources-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Resources'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        [
                'attribute' => 'folder.id',
                'label' => 'Folder'
            ],
        'name',
        'ext',
        'title',
//        'type_id',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
