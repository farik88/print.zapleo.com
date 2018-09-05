<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Labels'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Купоны'),
        'content' => $this->render('_dataCouponLabel', [
            'model' => $model,
            'row' => $model->couponLabels,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Скидки'),
        'content' => $this->render('_dataLabelSale', [
            'model' => $model,
            'row' => $model->labelSales,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts','Товары'),
        'content' => $this->render('_dataProductLabel', [
            'model' => $model,
            'row' => $model->productLabels,
        ]),
    ],
    ];
echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'class' => 'tes',
    'pluginOptions' => [
        'bordered' => true,
        'sideways' => true,
        'enableCache' => false
    ],
]);
?>
