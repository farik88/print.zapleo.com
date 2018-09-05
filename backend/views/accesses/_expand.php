<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;
$items = [
//    [
//        'label' => '<i class="glyphicon glyphicon-book"></i> '. Html::encode('Accesses'),
//        'content' => $this->render('_detail', [
//            'model' => $model,
//        ]),
//    ],
        [
        'label' => '<i class="glyphicon glyphicon-book"></i> '. Yii::t('backend_accesses','Пользователи'),
        'content' => $this->render('_dataAccessUser', [
            'model' => $model,
            'row' => $model->accessUsers,
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
