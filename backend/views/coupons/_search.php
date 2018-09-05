<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CouponsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-coupons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'discount_type')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::TYPE_PERCENT => '%',
            $model::TYPE_CURRENCY => '₴',
        ]
    ])?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::ACTIVE => Yii::t('backend_coupons','Активно'),
            $model::DISABLED => Yii::t('backend_coupons','Не активно'),
        ]
    ])?>

    <?= $form->field($model, 'type')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::TYPE_PRODUCT => Yii::t('backend_coupons','Продукт'),
            $model::TYPE_LABEL => Yii::t('backend_coupons','Марки'),
            $model::TYPE_COVER => Yii::t('backend_coupons','Чехлы'),
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend_form', 'Очистить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
