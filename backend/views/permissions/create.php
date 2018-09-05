<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('backend_permissions', 'Создать права');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_permissions','Права пользователей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-permissions-create">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <?= $form->field($form_model, 'name')->textInput(); ?>
    </div>
    
    <div class="form-group">
        <?= $form->field($form_model, 'description')->textarea(); ?>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Создать'), ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
