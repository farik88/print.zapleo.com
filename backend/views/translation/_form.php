<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LangMessage */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="lang-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\SourceLangMessage::find()->orderBy('id')->asArray()->all(), 'id', 'message'),
        'options' => ['placeholder' => Yii::t('backend_translations', 'Выбрать слово для перевода')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'language')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\Languages::find()->orderBy('id')->asArray()->all(), 'iso_code', 'title'),
        'options' => ['placeholder' => Yii::t('backend_translations', 'Выбрать язык перевода')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>


    <?= $form->field($model, 'translation')->textarea(['rows' => 6, 'placeholder' => Yii::t('backend_translations', 'Перевод')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form', 'Создать') : Yii::t('backend_form', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
