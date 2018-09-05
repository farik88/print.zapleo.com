<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Colors'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
//        [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Product Color'),
//        'content' => $this->render('_dataProductColor', [
//            'model' => $model,
//            'row' => $model->productColors,
//        ]),
//    ],
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
