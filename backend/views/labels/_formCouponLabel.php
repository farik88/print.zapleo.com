<div class="form-group" id="add-coupon-label">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

function dataMap($data1,$data2)
{
    $data=[];
    foreach ($data1 as $k=>$v)
    {
        if($data2[$k] == 1){
            $data2[$k] = '₴';
        }else{
            $data2[$k] = '%';
        }
        $data[$k]=$v.' '.$data2[$k];
    }
    return $data;
}

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'CouponLabel',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN],
        'coupon_id' => [
            'label' => Yii::t('backend_labels','Купон'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => dataMap(\yii\helpers\ArrayHelper::map(\backend\models\Coupons::find()->orderBy('id')->asArray()->all(), 'id', 'value'),\yii\helpers\ArrayHelper::map(\backend\models\Coupons::find()->orderBy('id')->asArray()->all(), 'id', 'type')),
            ],
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowCouponLabel(' . $key . '); return false;', 'id' => 'coupon-label-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('backend_form', 'Добавить'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowCouponLabel()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

