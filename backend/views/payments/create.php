<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Payments */

$this->title = Yii::t('backend_payments','Добавить метод оплаты');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Методы оплаты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
