<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = Yii::t('frontend_site','Вход');
$this->registerCssFile("@web/css/login.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/login.js",["depends" => 'frontend\assets\AppAsset']);
?>


<section class="content">
    <h1><?php echo Yii::t('frontend_site', 'Аккаунт'); ?></h1>
    <div class="wrapper">
        <!-- New user? -->
        <div class="new">
            <h2><?=Yii::t('frontend_site','Новый пользователь?')?></h2>
            <p><?=Yii::t('frontend_site','Регистрация проста и бесплатна!')?></p>
            <ul>
                <li><?=Yii::t('frontend_site','Быстрое оформление заказа')?></li>
                <li><?=Yii::t('frontend_site','Сохранение ваших адресов доставки')?></li>
            </ul>
            <button class="reg" type="button"  role="button" onclick="window.location.href='<?=\yii\helpers\Url::to(['/site/signup/'])?>'"><?=Yii::t('frontend_site','Регистрация')?></button>
        </div>
        <!-- Registered user? -->
        <div class="registered">
            <h2><?=Yii::t('frontend_site','зарегистрированы?')?></h2>
            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "\n{input}\n<div class=\"valid_error\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['placeholder'=>Yii::t('frontend_site','Ваше полное имя')]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>Yii::t('frontend_site','Пароль')]) ?>

            <?php // $form->field($model, 'rememberMe')->checkbox() ?>

                <?= Html::submitButton(Yii::t('frontend_site','войти'), ['role'=>"button",'class' => 'login','type' => "submit", 'name' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>
<!--            <form method="post" action="cabinet.php">-->
<!--                <input type="email" name="email" placeholder="Email">-->
<!--                <input type="password" placeholder="Пароль">-->
<!--                <button class="login" type="submit" role="button">войти</button>-->
<!--            </form>-->
        </div>
        <ul class="buttons">
            <button class="back" type="button" role="button" onclick="window.location.href='/site/index'">
                <svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
                    <path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
                </svg>
                <?=Yii::t('frontend_button','конструктор')?>
            </button>
        </ul>
    </div>
</section>