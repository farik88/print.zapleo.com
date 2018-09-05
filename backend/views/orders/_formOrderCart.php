<div class="form-group" id="add-order-cart">
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
    'formName' => 'OrderCart',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'visible' => false],
        'product_id' => [
            'label' => Yii::t('backend_orders','Товар'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Products::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
        ],
        'image_id' => [
            'label' => Yii::t('backend_orders','Файл'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Images::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'total' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => Yii::t('backend_orders','Сумма')
        ],
        'count' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => Yii::t('backend_orders','Количество')
        ],
        'cover_id' => [
            'label' => Yii::t('backend_orders','Чехол'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Covers::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'user_hash' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => Yii::t('backend_orders','User Hash')
        ],
        'color_id' => [
            'label' => Yii::t('backend_orders','Цвет'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Colors::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'user_id' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => Yii::t('backend_orders','Пользователь')
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowOrderCart(' . $key . '); return false;', 'id' => 'order-cart-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('backend_form', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowOrderCart()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

