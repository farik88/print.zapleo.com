<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Языки');
$this->params['breadcrumbs'][] = $this->title;

$appAsset = 'backend\assets\AppAsset';

$this->registerCssFile('@web/css/language.css',["depends" => $appAsset]);
$this->registerJsFile('@web/js/language.js',["depends" => $appAsset]);
?>
<div class="languages-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
//        [
//            'class' => 'kartik\grid\ExpandRowColumn',
//            'width' => '50px',
//            'value' => function ($model, $key, $index, $column) {
//                return GridView::ROW_COLLAPSED;
//            },
//            'detail' => function ($model, $key, $index, $column) {
//                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
//            },
//            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'expandOneOnly' => true
//        ],
        ['attribute' => 'id', 'visible' => false],
        'title',
        [
            'attribute' => 'comment',
            'value' => function($model){
                if(strlen($model->comment)>50){
                    $model->comment = substr($model->comment, 0, 50);
                    return $model->comment . ' ...';
                }
                return $model->comment;
            },
        ],
        [
            'attribute' => 'url',
            'format' => 'raw',
            'value' => function($model){
                return $model->url;
            }
        ],
        [
            'attribute' => 'file_id',
            'format' => 'raw',
            'value' => function($model){
                return (!is_null($model->file) ? Html::img(Yii::getAlias('@buploads').'/' . $model->file->title,['style' => 'width:50px;']) : '');
            },

        ],
        [
            'attribute' => 'active',
            'format' => 'raw',
            'value' => function($model){
                if($model->active == $model::LANG_ACTIVE){
                    return '<label data-lang-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="1" checked>
                              <div class="slider round"></div>
                            </label>';
                }else if($model->active == $model::LANG_DISABLED){
                    return '<label data-lang-id="'.$model->id.'" class="switch">
                              <input type="checkbox" value="0">
                              <div class="slider round"></div>
                            </label>';
                }
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-languages']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
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
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => false
                ]
            ]) ,
        ],
    ]); ?>

</div>
