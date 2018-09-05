<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('backend_roles', 'Создать новую роль');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-roles-create">
    
    <?= Html::beginForm(['roles/create'], 'post'); ?>
    
    <div class="form-group<?= isset($create_result['name']['message']) ? ' has-error' : '' ?>">
        <label class="control-label" for="name"><?= Yii::t('backend_roles', 'Название роли'); ?></label>
        <?= Html::input('text', 'Role[name]', (isset($create_result['name']['data'])) ? $create_result['name']['data'] : '', ['class' => 'form-control']); ?>
        <?= (isset($create_result['name']['message'])) ? '<div class="help-block">' . $create_result['name']['message'] . '</div>' : ''; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Создать'), ['class' => 'btn btn-success']) ?>
    </div>
    
    <?= Html::endForm(); ?>
    
</div>
