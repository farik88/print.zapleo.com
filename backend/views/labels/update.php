<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Labels */

$this->title = Yii::t('backend_labels','Обновить марку товара').': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Марки товаров'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="labels-update">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
