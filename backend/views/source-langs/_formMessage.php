<div class="form-group" id="add-message">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Message',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'language' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => Yii::t('backend_source-messages', 'Язык'),
            ],
//        'language' => ['type' => TabularForm::INPUT_TEXT],
        'translation' => [
            'type' => TabularForm::INPUT_TEXTAREA,
            'label' => Yii::t('backend_source-messages', 'Перевод'),
            ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowMessage(' . $key . '); return false;', 'id' => 'message-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('backend_source-messages', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowMessage()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

