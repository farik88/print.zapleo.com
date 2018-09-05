<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Images */

$this->title = Yii::t('backend_images','Обновить изображение').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Картинки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="images-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
