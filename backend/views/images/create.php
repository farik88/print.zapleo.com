<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Images */

$this->title = Yii::t('backend_images','Добавить изображение');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Картинки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
