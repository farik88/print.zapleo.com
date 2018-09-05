<div class="form-group" id="add-coupons">
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
//echo TabularForm::widget([
//    'dataProvider' => $dataProvider,
//    'formName' => 'Coupons',
//    'checkboxColumn' => false,
//    'actionColumn' => false,
//    'attributeDefaults' => [
//        'type' => TabularForm::INPUT_TEXT,
//    ],
//    'attributes' => [
//        'id' => ['type' => TabularForm::INPUT_HIDDEN],
//        'hash' => ['type' => TabularForm::INPUT_TEXT],
//        'del' => [
//            'type' => 'raw',
//            'label' => '',
//            'value' => function($model, $key) {
//                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowCoupons(' . $key . '); return false;', 'id' => 'coupons-del-btn']);
//            },
//        ],
//    ],
//    'gridSettings' => [
//        'panel' => [
//            'heading' => false,
//            'type' => GridView::TYPE_DEFAULT,
//            'before' => false,
//            'footer' => false,
//            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Coupons', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowCoupons()']),
//        ]
//    ]
//]);
echo  "    </div>\n\n";
?>

