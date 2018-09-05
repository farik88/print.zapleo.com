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
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'visible' => false],
        'delivery_id' => [
            'label' => Yii::t('backend_coupons','Доставка'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveries::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'payment_id' => [
            'label' => Yii::t('backend_coupons','Оплата'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Payments::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'user_id' => [
            'label' => Yii::t('backend_coupons','Пользователь'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Users::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'total' => ['type' => TabularForm::INPUT_TEXT],
        'comment' => ['type' => TabularForm::INPUT_TEXTAREA],
        'status_payment' => ['type' => TabularForm::INPUT_TEXT],
        'status_delivery' => ['type' => TabularForm::INPUT_TEXT],
        'data' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
                'saveFormat' => 'php:Y-m-d H:i:s',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Data',
                        'autoclose' => true,
                    ]
                ],
            ]
        ],
        'address' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowOrders(' . $key . '); return false;', 'id' => 'orders-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('backend_form', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowOrders()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

