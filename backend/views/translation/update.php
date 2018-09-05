<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LangMessage */

$this->title = Yii::t('backend_translations','Обновить перевод').': ' . ' ' . $model->translation;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Переводы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="lang-message-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
