<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Labels */

$this->title = Yii::t('backend_labels','Добавить марку товара');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Марки товаров'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labels-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
