<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Covers */

$this->title = Yii::t('backend_covers','Добавить чехол');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Чехлы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="covers-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
