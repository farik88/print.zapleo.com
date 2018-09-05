<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Sales */

$this->title = Yii::t('backend_sales','Добавление акции');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Акции'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
