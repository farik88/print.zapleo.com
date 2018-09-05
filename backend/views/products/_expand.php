<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Products'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
//        [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Заказы'),
//        'content' => $this->render('_dataOrderProduct', [
//            'model' => $model,
//            'row' => $model->orderProducts,
//        ]),
//    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Цвета'),
        'content' => $this->render('_dataProductColor', [
            'model' => $model,
            'row' => $model->productColors,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Купоны'),
        'content' => $this->render('_dataProductCoupon', [
            'model' => $model,
            'row' => $model->productCoupons,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products', 'Чехлы'),
        'content' => $this->render('_dataProductCover', [
            'model' => $model,
            'row' => $model->productCovers,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Марки'),
        'content' => $this->render('_dataProductLabel', [
            'model' => $model,
            'row' => $model->productLabels,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Разметки'),
        'content' => $this->render('_dataProductMarking', [
            'model' => $model,
            'row' => $model->productMarkings,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Скидки'),
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
