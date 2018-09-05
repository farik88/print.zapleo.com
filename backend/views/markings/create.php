<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Markings */

$this->title = Yii::t('backend_markings','Добавить Разметку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Разметки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markings-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
