<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Картинки');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-index">

    <p>
        <?php // Html::a('Создать Изобраения', ['create'], ['class' => 'btn btn-success']) ?>
        <?php // Html::a('Расширеный поиск', '#', ['class' => 'btn btn-info search-button']) ?>

        <?php
        echo \kartik\file\FileInput::widget([
            'name' => 'file',
            'language' => \Yii::$app->controller->current_lang->url,
            'options'=>[
                'multiple'=>true
            ],
            'pluginOptions' => [
                'uploadUrl' => \yii\helpers\Url::to(['site/load-images']),
                'maxFileCount' => 10
            ],
            'pluginEvents' => [
                'fileuploaded' => 'function(event, data, previewId, index) {
            location.reload();
            }'
            ]
        ]);
        ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        //'id',
        'title',
        'name',
        'ext',
        [
            //'attribute' => 'file_id',
            'label' => Yii::t('backend_images','Файл'),
            'format' => 'raw',
            'value' => function($model){
                return Html::img(Yii::getAlias('@buploads').'/print/' . $model->name .'.'.$model->ext,[
                    'style' => 'width:50px;'
                ]);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\backend\models\Files::find()->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Files', 'id' => 'grid-products-search-file_id']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-images']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
