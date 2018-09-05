<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Markings */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Markings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markings-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Markings'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'name',
        [
                'attribute' => 'product.name',
                'label' => 'Product'
            ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
