<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Colors */

$this->title = Yii::t('backend_colors','Добавить цвет');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Цвета'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colors-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
