<div class="form-group" id="add-order-product">
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
    'formName' => 'OrderProduct',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        //'id' => ['type' => TabularForm::INPUT_HIDDEN],
        'product_id' => [
            'label' => Yii::t('backend_images','Товар'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Products::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'order_id' => [
            'label' => Yii::t('backend_images','Заказ'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Orders::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'total' => [
            'type' => TabularForm::INPUT_TEXT,
            'label'=> Yii::t('backend_images','Сумма')
        ],
        'count' => ['type' => TabularForm::INPUT_TEXT,
            'label'=> Yii::t('backend_images','Количество')
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowOrderProduct(' . $key . '); return false;', 'id' => 'order-product-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('backend_form', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowOrderProduct()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

