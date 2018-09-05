<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Sales */

$this->title = Yii::t('backend_sales','Обновление Акции').': ' . ' ' . $model->value;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Акции'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="sales-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
