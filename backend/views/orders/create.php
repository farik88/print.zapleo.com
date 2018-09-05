<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Orders */

$this->title = Yii::t('backend_orders','Создание Заказа');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Заказы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
