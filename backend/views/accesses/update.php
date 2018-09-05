<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Accesses */

$this->title = Yii::t('backend_accesses','Обновить доступ').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Права доступа'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="accesses-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
