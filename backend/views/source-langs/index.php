<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use \common\models\SourceLangMessage;

$this->title = Yii::t('backend_layouts','Исходные сообщения');
$this->params['breadcrumbs'][] = $this->title;

$categories = SourceLangMessage::find()->select('category')->groupBy('category')->orderBy('category')->asArray()->all();

foreach ($categories as $i => $category)
    $categories[$i]['category_name'] = (!empty(SourceLangMessage::$categories[$category['category']]) ? SourceLangMessage::$categories[$category['category']] : $category['category']);

?>
<div class="source-lang-message-index">

    <p>
        <?= Html::a(Yii::t('backend_form', 'Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
//var_dump(ArrayHelper::map(SourceLangMessage::find()->orderBy('message')->asArray()->all(), 'id', 'message'));
//die();
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
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute'=>'message',
            'filterType'=> GridView::FILTER_SELECT2,
            'filter'=> ArrayHelper::map(SourceLangMessage::find()->orderBy('message')->asArray()->all(), 'message', 'message'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder' => Yii::t('backend_source-messages', 'Поиск сообщения...')],
            'format'=>'raw'
        ],
        [
            'attribute'=>'category',
            'filterType'=> GridView::FILTER_SELECT2,
            'filter'=> ArrayHelper::map($categories, 'category', 'category_name'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder' => Yii::t('backend_source-messages', 'Поиск категории...')],
            'format'=>'raw',
            'value' => function ($model) {
                return (!empty(SourceLangMessage::$categories[$model->category]) ? SourceLangMessage::$categories[$model->category] : $model->category);
            }
        ],
        [
            'class' => '\kartik\grid\DataColumn',
            'width' => '30px',
            'format' => 'html',
            'label' => Yii::t('backend_source-messages', 'Статус'), 
            'value'=>function ($model, $key, $index, $column) {
                return $model->getTranslateStatus();
            },
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-source-lang-message']],
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
