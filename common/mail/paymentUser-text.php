<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$link = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
Здравствуйте, <?= $user->username ?>,

Вы оплатили заказ!

<?= $link ?>
