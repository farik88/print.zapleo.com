<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Images'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_images','Заказ и Товар'),
        'content' => $this->render('_dataOrderCart', [
            'model' => $model,
            'row' => $model->orderCarts,
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
