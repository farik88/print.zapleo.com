<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'OrderCart',
        'relID' => 'order-cart',
        'value' => \yii\helpers\Json::encode($model->orderCarts),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id',['template' => '{input}'])->textInput(['placeholder' => 'Id','style' => 'display:none']) ?>

    <?= $form->field($model, 'delivery_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Deliveries::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'payment_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Payments::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'coupon_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Coupons::find()->orderBy('id')->asArray()->all(), 'id', 'hash'),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Users::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_payment')->widget(\kartik\widgets\Select2::className(),[
            'data' => [
                $model::PAYMENT_ACCEPTED =>Yii::t('backend_orders','Оплачено'),
                $model::PAYMENT_EXPECTATION => Yii::t('backend_orders','Ожидание оплаты'),
                $model::PAYMENT_ERROR => Yii::t('backend_orders','Ошибка')
            ]
    ])?>

    <?= $form->field($model, 'status_delivery')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::DELIVERY_ACCEPTED => Yii::t('backend_orders','Доставлено'),
            $model::DELIVERY_ON_MY_WAY => Yii::t('backend_orders','Отправлено'),
            $model::DELIVERY_EXPECTATION => Yii::t('backend_orders','Ожидание отправки')
        ]
    ]) ?>



    <?= $form->field($model, 'data')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'displayFormat' => 'php:d-m-Y H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Yii::t('backend_orders','Товар с фото'),
            'content' => $this->render('_formOrderCart', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->orderCarts),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form','Создать') : Yii::t('backend_form','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
