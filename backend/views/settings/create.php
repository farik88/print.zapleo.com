<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\SettingRecord */

$this->title = Yii::t('backend_form','Добавить');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Параметры приложения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-record-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
