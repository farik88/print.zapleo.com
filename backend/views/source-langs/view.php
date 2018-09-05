<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\base\SourceLangMessage */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Исходные сообщения'), 'url' => ['index']];
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
<div class="source-lang-message-view" style="padding-left: 15px; padding-right: 15px;">

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute'=>'category',
            'value' => function ($model) {
                return (!empty(\common\models\SourceLangMessage::$categories[$model->category]) ? \common\models\SourceLangMessage::$categories[$model->category] : $model->category);
            }
        ],
        'message:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerMessage->totalCount){
    $gridColumnMessage = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'lang_title' => [
            'format'=>'raw',
            'label' => Yii::t('backend_source-langs', 'Язык'),
            'value' => function($m) {
                return Html::img(Yii::getAlias('@buploads').'/'.$m->languageInfo->file->title, ['style' => 'width:35px;height:35px;border-radius:50%;margin: 0 20px 0 0;display:inline-block;']) .  $m->languageInfo->title;
            }
        ],
        'translation' => [
            'attribute' => 'translation',
            'label' => Yii::t('backend_source-langs', 'Перевод')
        ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerMessage,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-message']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Message'),
        ],
        'export' => false,
        'columns' => $gridColumnMessage
    ]);
}
?>
    </div>
</div>
