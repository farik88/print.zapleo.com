<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LangMessage */

$this->title = Yii::t('backend_translations','Добавить перевод');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Переводы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-message-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
