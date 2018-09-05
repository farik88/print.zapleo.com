<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Folders */

$this->title = Yii::t('backend_folders','Добавить папку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_folders','Папки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folders-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
