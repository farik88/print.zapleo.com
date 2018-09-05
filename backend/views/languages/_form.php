<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="languages-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->widget(\kartik\widgets\Select2::className(),[
        'data' => [
            $model::LANG_ACTIVE=>Yii::t('backend_languages','Активно'),
            $model::LANG_DISABLED=>Yii::t('backend_languages','Не активно'),
        ]
    ]) ?>
    
    <?= $form->field($model, 'iso_code')->textInput(['maxlength' => 5, 'placeholder' => 'ru_RU']) ?>
    
    <?= $form->field($model, 'url')->textInput(['placeholder' => 'ru']) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file_id')->textInput(['style' => 'display:none']) ?>

    <?php
    echo \kartik\file\FileInput::widget([
        'name' => 'file',
        'language' => \Yii::$app->controller->current_lang->url,
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'uploadUrl' => \yii\helpers\Url::to(['site/load-file']),
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function(event, data, previewId, index) {
            console.log(data["response"]["file_id"]);
            $("#languages-file_id").val(data["response"]["file_id"]);
            }'
        ]
    ]);
    ?>
<br/>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend_form','Создать') : Yii::t('backend_form','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
