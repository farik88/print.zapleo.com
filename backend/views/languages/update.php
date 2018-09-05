<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Languages */

$this->title = Yii::t('backend_languages','Обновить язык').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Языки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="languages-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
