<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = Yii::t('backend_roles', 'Редактировать роль');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_roles', 'Роли пользователей'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-roles-update">
    
    <?= Html::beginForm(['roles/update'], 'post'); ?>
    
    <div class="form-group">
        <label class="control-label" for="name"><?= Yii::t('backend_roles', 'Название роли'); ?></label>
        <?= Html::hiddenInput('Role[origin_name]', $role->name); ?>
        <?= Html::input('text', 'Role[name]', $role->name, ['class' => 'form-control']); ?>
        <!--<div class="help-block">Error text</div>-->
    </div>
    <div class="form-group">
        <?= Html::checkbox('Role[is_default_role]', $is_default_role, ['style' => 'width: 15px;height: 15px;vertical-align: middle;cursor: pointer;margin: 0 8px 0 0;']); ?>
        <label class="control-label" for="name"><?= Yii::t('backend_roles', 'Использовать эту роль по умолчанию'); ?></label>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend_form', 'Обновить'), ['class' => 'btn btn-success']); ?>
    </div>
    
    <?= Html::endForm(); ?>

</div>
