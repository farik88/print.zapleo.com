<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Colors */

$this->title = Yii::t('backend_colors','Обновить цвет').': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Цвета'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="colors-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
