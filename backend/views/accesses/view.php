<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Accesses */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Accesses', 'url' => ['index']];
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
<div class="accesses-view" style="padding-left: 15px; padding-right: 15px;"->

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'value',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerAccessUser->totalCount){
    $gridColumnAccessUser = [
//        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'user.id',
            'label' => 'Id'
        ],
        [
            'attribute' => 'user.username',
            'label' => Yii::t('backend_accesses','Имя')
        ],
        [
            'attribute' => 'user.email',
            'label' => Yii::t('backend_accesses','Почта')
        ],

    ];
    echo Gridview::widget([
        'dataProvider' => $providerAccessUser,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-access-user']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Yii::t('backend_accesses','Пользователи'),
        ],
        'export' => false,
        'columns' => $gridColumnAccessUser
    ]);
}
?>
    </div>
</div>
