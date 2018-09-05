<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */

$this->title = Yii::t('backend_coupons','Обновление купона') . ': ' . $model->hash;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Купоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hash, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="coupons-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
