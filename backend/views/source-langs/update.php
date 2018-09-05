<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\SourceLangMessage */

$this->title = Yii::t('backend_source-messages', 'Перевод слова') . ' «' . $model->message . '»';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Исходные сообщения'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->message, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend_form','Обновить');
?>
<div class="source-lang-message-update">

    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
