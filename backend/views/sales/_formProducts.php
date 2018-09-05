<div class="form-group" id="add-products">
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
    'formName' => 'Products',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN],
        'name' => ['type' => TabularForm::INPUT_TEXT],
        'price' => ['type' => TabularForm::INPUT_TEXT],
        'file_id' => [
            'label' => 'Files',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Files::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
                'options' => ['placeholder' => 'Choose Files'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'wspace_width' => ['type' => TabularForm::INPUT_TEXT],
        'wspace_height' => ['type' => TabularForm::INPUT_TEXT],
        'wspace_width3d' => ['type' => TabularForm::INPUT_TEXT],
        'wspace_height3d' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowProducts(' . $key . '); return false;', 'id' => 'products-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Products', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProducts()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

