<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Folders */

$this->title = Yii::t('backend_folders','Обновить папку').': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_folders','Папки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="folders-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
