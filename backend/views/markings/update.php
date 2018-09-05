<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Markings */

$this->title = Yii::t('backend_markings','Обновить разметку').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Разметки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="markings-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
