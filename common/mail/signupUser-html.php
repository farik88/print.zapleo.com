<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
<div class="password-reset">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>.</p>

    <p>Спасибо, что зарегистрировались в MyCase!</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
