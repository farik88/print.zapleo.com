<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Folders'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_folders','Ресурсы'),
        'content' => $this->render('_dataResources', [
            'model' => $model,
            'row' => $model->resources,
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
