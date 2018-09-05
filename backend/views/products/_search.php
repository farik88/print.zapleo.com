<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Files::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
    ]); ?>

    <?= $form->field($model, 'wspace_width') ?>

    <?php /* echo $form->field($model, 'wspace_height')->textInput(['placeholder' => 'Wspace Height']) */ ?>

    <?php /* echo $form->field($model, 'wspace_width3d')->textInput(['placeholder' => 'Wspace Width3d']) */ ?>

    <?php /* echo $form->field($model, 'wspace_height3d')->textInput(['placeholder' => 'Wspace Height3d']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Поиск'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend_form', 'Очистить'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
