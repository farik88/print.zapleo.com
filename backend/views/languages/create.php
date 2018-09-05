<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Languages */

$this->title = Yii::t('backend_languages','Добавить язык');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Языки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="languages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
