<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Covers */

$this->title = Yii::t('backend_covers','Обновить чехол').': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Чехлы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="covers-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
