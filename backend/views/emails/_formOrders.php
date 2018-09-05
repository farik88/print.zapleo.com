<div class="form-group" id="add-orders">
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
    'formName' => 'Orders',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        //'id' => ['type' => TabularForm::INPUT_HIDDEN],
        'delivery_id' => [
            'label' => 'Доставка',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveries::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите способ доставки'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'payment_id' => [
            'label' => 'Оплата',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Payments::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите способ оплаты'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'coupon_id' => [
            'label' => 'Купон',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Coupons::find()->orderBy('id')->asArray()->all(), 'id', 'hash'),
                'options' => ['placeholder' => 'Выберите купон'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'total' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => 'Сумма',
        ],
        'comment' => [
            'type' => TabularForm::INPUT_TEXTAREA,
            'label' => 'Комментарий',
        ],
        'status_payment' => [
            'label' => 'Статус оплата',
            'type' => TabularForm::INPUT_TEXT,

        ],
        'status_delivery' => [
                'type' => TabularForm::INPUT_TEXT,
            'label' => 'Статус доставки',
        ],
        'data' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'label' => 'Дата',
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'displayFormat' => 'php:d-m-Y H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Data',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'address' => [
            'type' => TabularForm::INPUT_TEXT,
            'label' => 'Адрес',
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowOrders(' . $key . '); return false;', 'id' => 'orders-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Orders', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowOrders()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

