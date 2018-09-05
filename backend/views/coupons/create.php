<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Coupons */

$this->title = Yii::t('backend_coupons','Добавление купона');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Купоны'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupons-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
