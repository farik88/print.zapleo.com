<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Payments */

$this->title = Yii::t('backend_payments','Обновить метод оплаты').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Методы оплаты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="payments-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
