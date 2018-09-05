<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = Yii::t('backend_users','Создать Пользователя');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Все ользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
