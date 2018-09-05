<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Sales'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts','Чехлы'),
        'content' => $this->render('_dataCoverSale', [
            'model' => $model,
            'row' => $model->coverSales,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts','Марки товаров'),
        'content' => $this->render('_dataLabelSale', [
            'model' => $model,
            'row' => $model->labelSales,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts','Товары'),
        'content' => $this->render('_dataProductSale', [
            'model' => $model,
            'row' => $model->productSales,
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
