<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\SettingRecord */

$this->title = Yii::t('backend_form','Обновить') . ': ' . $model->value;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Параметры приложения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="setting-record-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
