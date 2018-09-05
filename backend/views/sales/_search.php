<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-sales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'data_start')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Data Start',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'data_end')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME,
        'saveFormat' => 'php:Y-m-d H:i:s',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Data End',
                'autoclose' => true,
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'type')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            $model::PERCENT=>'%',
            $model::CURRENCY=>'₴',
        ],
    ])?>

    <?php  echo $form->field($model, 'active')->widget(\kartik\widgets\Select2::classname(), [
        'data' => [
            1 => Yii::t('backend_sales','Активные'),
            0 => Yii::t('backend_sales','Не активные'),
        ],
    ])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend_form', 'Очистить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
