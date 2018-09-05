<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Языки'), 'url' => ['index']];
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
<div class="languages-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        [
            'attribute' => 'active',
            'value' => function($model){
                switch ($model->active){
                    case $model::LANG_ACTIVE:
                        return Yii::t('backend_languages','Активно');
                    case $model::LANG_DISABLED:
                        return Yii::t('backend_languages','Не активно');
                    default:
                        return "error";

                }
            },
        ],
        'comment:ntext',
        [
            'label' => Yii::t('backend_languages','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return (!is_null($model->file) ? Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,['style' => 'width:50px;']) : '');

            },
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
