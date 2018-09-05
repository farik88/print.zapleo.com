<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('backend_permissions', 'Редактировать права');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_permissions', 'Права пользователей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-permissions-update">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <?= Html::hiddenInput('PermissionsForm[origin_name]', $permission->name); ?>
        <?= $form->field($form_model, 'name')->textInput(['value' => $permission->name]); ?>
    </div>
        
    <div class="form-group">
        <?= $form->field($form_model, 'description')->textarea(['value' => $permission->description]); ?>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Обновить'), ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
    
</div>
