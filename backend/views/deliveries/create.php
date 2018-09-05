<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Deliveries */

$this->title = Yii::t('backend_deliveries','Добавить метод доставки');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts', 'Методы доставки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliveries-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model_msg' => $model_msg,
        'langs' => $langs
    ]) ?>

</div>
