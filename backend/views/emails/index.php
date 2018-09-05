<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('backend_layouts','Почта/рассылка');
$this->params['breadcrumbs'][] = $this->title;

$appAsset = 'frontend\assets\AppAsset';

$this->registerCssFile('@web/css/email.css',["depends" => $appAsset]);
$this->registerJsFile('@web/js/email.js',["depends" => $appAsset]);
?>
<div class="users-index">

    <div class="form-group">
        <label><?=Yii::t('backend_emails','Сообщение')?></label>
        <textarea id="message_text" class="form-control" rows="3" placeholder="<?=Yii::t('backend_emails','Введите текст сообщения')?>"></textarea>
    </div>
    <p>
        <?= Html::a(Yii::t('backend_emails','Разослать'), ['#'], ['class' => 'btn btn-success confirm']) ?>
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
    [
            'format' => 'raw',
            'value'=> function ($model){
                return '<div class="checkbox">
                            <input type="checkbox" value="'.$model->email.'" checked="checked">
                        </div>';
            }
    ],
        'id',
        'username',
        'email:email',
        'auth_key',
        //'password_hash',
       // 'password_reset_token',

       // 'status',
        [
            'attribute' => 'created_at',
            'value' => function($model){
                return date('d.m.y',$model->created_at);
            },
        ],
        [
            'attribute' => 'last_active',
            'value' => function($model){
                return $model->last_active;
            },
        ],

        [
            'attribute' => 'updated_at',
            'value' => function($model){
                return date('d.m.y',$model->updated_at);
            },
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return '<a href="/users/view?id='.$model->id.'" title="View" aria-label="View" data-pjax="0">'.
                        '<span class="glyphicon glyphicon-eye-open"></span></a>';
                }
            ],
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-users']],
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
