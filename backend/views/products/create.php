<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = Yii::t('backend_products', 'Добавить товар');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Товары'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
