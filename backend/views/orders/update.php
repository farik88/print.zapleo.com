<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = Yii::t('backend_orders','Обновить заказ').': ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Заказы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="orders-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
