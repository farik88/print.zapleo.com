<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
    [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts','Чехлы'),
        'content' => $this->render('_detail', [
            'model' => $model,
        ]),
    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Купоны'),
        'content' => $this->render('_dataCouponCover', [
            'model' => $model,
            'row' => $model->couponCovers,
        ]),
    ],
            [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_products','Скидки'),
        'content' => $this->render('_dataCoverSale', [
            'model' => $model,
            'row' => $model->coverSales,
        ]),
    ],
                [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_layouts', 'Товары'),
        'content' => $this->render('_dataProductCover', [
            'model' => $model,
            'row' => $model->productCovers,
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
