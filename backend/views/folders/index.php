<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

switch ($type){
    case \backend\models\Folders::TYPE_EMOJI:
        $this->title = Yii::t('backend_layouts','Emoji');
            break;
    case \backend\models\Folders::TYPE_FONTS:
        $this->title = Yii::t('backend_layouts','Шрифты');
            break;
    case \backend\models\Folders::TYPE_BACKGROUND:
        $this->title = Yii::t('backend_layouts','Фоны');
            break;
    default:
        $this->title = 'error';
        break;
}


$this->params['breadcrumbs'][] = $this->title;

$appAsset = 'backend\assets\AppAsset';

$this->registerJsFile('@web/js/folder.js',["depends" => $appAsset]);
?>
<div class="folders-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
    </p>
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
        //'parent_folder',
        'name',
        //'type_id',
//        [
//                'attribute' => 'type_id',
//                'value' => function($model){
//                    switch ($model->type_id){
//                        case $model::TYPE_EMOJI:
//                            return 'Emoji';
//                        case $model::TYPE_FONTS:
//                            return 'Шрифты';
//                        case $model::PAYMENT_ERROR:
//                            return 'Фоны';
//                        default:
//                            return "error";
//
//                    }
//                }
//        ],

//        [
//            'class' => 'yii\grid\ActionColumn',
//        ],
//---------------------------------------------------------------------
        ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view} {update} {deleteb}',
            'buttons'=>[
                'deleteb' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => Yii::t('backend_form', 'Удалить'),
                    ]);

                }
            ]
        ],
//---------------------------------------------------------------------

//        [
//            'class' => \yii\grid\ActionColumn::className(),

//            'buttons'=>[
//                'view'=>function ($url, $model) {
//                    $customurl=Yii::$app->getUrlManager()->createUrl(['log/view','id'=>$model['id']]);
//                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
//                        ['title' => Yii::t('back_folders_index', 'View'), 'data-pjax' => '0']);
//                }
//            ],
//            'urlCreator'=>function($action, $model, $key, $index){
//                $customurl=Yii::$app->getUrlManager()->createUrl(['log/view','id'=>$model['id']]);
//                return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
//                    ['title' => Yii::t('back_folders_index', 'View'), 'data-pjax' => '0']);
//            },
            //'template'=>'{view}{update}{delete}',
//        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-folders']],
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
