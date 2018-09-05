<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

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
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Coupons::find()->orderBy('id')->asArray()->all(), 'id', 'id'),
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

    <?php /* echo $form->field($model, 'total')->textInput(['placeholder' => 'Total']) */ ?>

    <?php /* echo $form->field($model, 'comment')->textarea(['rows' => 6]) */ ?>

    <?php  echo $form->field($model, 'status_payment')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            $model::PAYMENT_ACCEPTED =>Yii::t('backend_orders','Оплачено'),
            $model::PAYMENT_EXPECTATION => Yii::t('backend_orders','Ожидание оплаты'),
            $model::PAYMENT_ERROR => Yii::t('backend_orders','Ошибка')
        ],
    ])  ?>

    <?php  echo $form->field($model, 'status_delivery')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            $model::DELIVERY_ACCEPTED => Yii::t('backend_orders','Доставлено'),
            $model::DELIVERY_ON_MY_WAY => Yii::t('backend_orders','Отправлено'),
            $model::DELIVERY_EXPECTATION => Yii::t('backend_orders','Ожидание отправки')
        ],
    ])  ?>

    <?php  echo $form->field($model, 'data')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Data',
                'autoclose' => true,
            ]
        ],
    ]);  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend_form', 'Очистить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
