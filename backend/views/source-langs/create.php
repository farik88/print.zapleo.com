<?php

use yii\helpers\Html;


$this->title = Yii::t('backend_source-messages', 'Создать исходное сообщение');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend_layouts','Исходные сообщения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-lang-message-create">

    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
