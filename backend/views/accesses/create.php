<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Accesses */

$this->title = Yii::t('backend_accesses','Добавление должности');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Права доступа'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accesses-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
