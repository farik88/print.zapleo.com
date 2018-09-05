<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t('frontend_site','Регистрация');
$this->registerCssFile("@web/css/login.css",["depends" => 'frontend\assets\AppAsset']);
//var_dump($msg);
?>
<section class="content">
    <h1><?=Yii::t('frontend_site','аккаунт')?></h1>
    <div class="wrapper">


        <!-- New user? -->
        <div class="create">
            <button class="close" type="button" onclick="window.location.href='<?=\yii\helpers\Url::to(['/site/login/'])?>'">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><path fill="#333" d="M2.5 13.65L0 11.15l4.34-4.32L0 2.5 2.5 0l4.33 4.34L11.17 0l2.48 2.5-4.33 4.33 4.33 4.33-2.5 2.5L6.84 9.3z"></path></svg>
                <?=Yii::t('frontend_site','Закрыть')?>
            </button>
            <h2><?=Yii::t('frontend_site','создать аккаунт')?></h2>
            <?php $form = ActiveForm::begin([
                    'id' => 'form-signup',
                'fieldConfig' => [
                    'template' => "\n{input}\n<div class=\"valid_error\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['placeholder'=>Yii::t('frontend_site','Ваше полное имя')]) ?>

            <?= $form->field($model, 'email')->input('email')->textInput(['placeholder'=>Yii::t('frontend_site','Email')]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>Yii::t('frontend_site','Пароль')]) ?>

            <?= $form->field($model, 'password2')->passwordInput(['placeholder'=>Yii::t('frontend_site','Пароль еще раз')]) ?>

            <?php // $form->field($model, 'captcha')->widget(Captcha::className()) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend_site','Регистрация'), ['class' => 'reg', 'type'=>"button" ,'role'=>"button",'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
<!--            <form method="post" action="#">-->
<!--                <input type="text" placeholder="Ваше полное имя">-->
<!--                <input type="email" placeholder="Email">-->
<!--                <input type="password" placeholder="Пароль">-->
<!--                <input type="password" placeholder="Пароль ещё раз">-->
<!--                <button class="reg" type="button" role="button">Регистрация</button>-->
<!--            </form>-->
        </div>
    </div>
</section>
