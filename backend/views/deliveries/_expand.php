<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Deliveries'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Orders'),
        'content' => $this->render('_dataOrders', [
            'model' => $model,
            'row' => $model->orders,
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
