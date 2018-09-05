<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
Здравствуйте, <?= $user->username ?>,

Спасибо, что зарегистрировались в MyCase!

<?= $resetLink ?>
