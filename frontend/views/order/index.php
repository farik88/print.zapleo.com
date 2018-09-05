<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 15.05.17
 * Time: 11:13
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('frontend_order','Оформление заказа');
$this->registerCssFile("@web/css/order.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/order.js",["depends" => 'frontend\assets\AppAsset']);
$urli = \Yii::getAlias('@buploads');

//var_dump(Yii::$app->getUser()->id)
function saleInPercent($price_prod,$val,$ctn){
    return ($price_prod * ($val / 100))*$ctn;
}
function saleInCurrency($price_prod,$val,$ctn){
    return ($price_prod - ($price_prod - $val))*$ctn;
}
$sale=0;
function getSaleValue($price_prod = null, $disc_typr = null,$val= null,$ctn=null,$sale){

    if($disc_typr == 0){ //%
        $sale += saleInPercent($price_prod,$val,$ctn);
    }else{
        $sale += saleInCurrency($price_prod,$val,$ctn);
    }

    return $sale;
}
?>
<section class="content">
    <h1><?=Yii::t('frontend_order','оформление заказа')?></h1>
<section>
    <?php if(!isset($cart) || empty($cart)):?>
    <div class="message">
        <p><?=Yii::t('frontend_order','У вас нет товаров в корзине для оформления заказа!')?></p>
        <p><?=Yii::t('frontend_order','Заполните корзину что бы можно было оформить заказ!')?></p>
    </div>
        <ul class="buttons">
            <li>
                <button class="back" type="button" role="button" onclick="window.location.href='/site/index'">
                    <svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
                        <path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
                    </svg>
                    <span><?=Yii::t('frontend_button','конструктор')?></span>
                </button>
            </li>
        </ul>
	</section>
</section>
    <?php else:?>
        <!-- User info -->
            <div class="container">
                <div class="data">
                    <header><?=Yii::t('frontend_order','Для оформления заказа вы должны')?><br><?=Yii::t('frontend_order','быть авторизованы')?></header>
                    <div class="new">
                        <h2><?=Yii::t('frontend_order','новый пользователь?')?></h2>
                        <p><?=Yii::t('frontend_order','Регистрация проста и бесплатна!')?></p>
                        <ul>
                            <li><?=Yii::t('frontend_order','Быстрое оформление заказа')?></li>
                            <li><?=Yii::t('frontend_order','Сохранение ваших адресов доставки')?></li>
                        </ul>
                        <button class="reg" type="button" role="button"><?=Yii::t('frontend_order','Регистрация')?></button>
                    </div>
                    <div class="registered">
                        <h2><?=Yii::t('frontend_order','зарегистрированы?')?></h2>
                        <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                            'fieldConfig' => [
                                'template' => "\n{input}\n<div class=\" valid_error\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-2 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($login, 'username')->textInput(['placeholder'=>Yii::t('frontend_order','Ваше полное имя')]) ?>

                        <?= $form->field($login, 'password')->passwordInput(['placeholder'=>Yii::t('frontend_order','Пароль')]) ?>

                        <?php // $form->field($login, 'rememberMe')->checkbox() ?>

                        <?= Html::submitButton('войти', ['role'=>"button",'class' => 'login','type' => "submit", 'name' => 'login-button']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                    <aside class="registration" style="display:none">
                        <h2><?=Yii::t('frontend_order','создать аккаунт')?></h2>
                        <?php $form = ActiveForm::begin([
                                'id' => 'form-signup',
                            'fieldConfig' => [
                                'template' => "\n{input}\n<div class=\"valid_error\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-2 control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($signup, 'username')->textInput(['placeholder'=>Yii::t('frontend_order','Ваше полное имя')]) ?>

                        <?= $form->field($signup, 'email')->input('email')->textInput(['placeholder'=>Yii::t('frontend_order','Email')]) ?>

                        <?= $form->field($signup, 'password')->passwordInput(['placeholder'=>Yii::t('frontend_order','Пароль')]) ?>

                        <?= $form->field($signup, 'password2')->passwordInput(['placeholder'=>Yii::t('frontend_order','Пароль еще раз')]) ?>

                        <?= $form->field($signup, 'phone')->input('tel')->textInput(['class'=>'tel','placeholder'=>Yii::t('frontend_order','Телефон')]) ?>

                        <?php // $form->field($model, 'captcha')->widget(Captcha::className()) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('frontend_order','Регистрация'), ['class' => 'reg', 'type'=>"button" ,'role'=>"button",'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </aside>
                </div>

                <!-- User info -->
                <div class="result">
                    <ul>
                        <?php foreach ($cart as $v):?>
                        <li>
                            <?php if($v['cover']['title'] == 'silikon'):?>
                            <div class="custom_design">
                                    <img class="phone_preview" src="<?=$urli?>/colors/<?=$v['producrt_color_file_id']['name'].'.'.$v['producrt_color_file_id']['ext']?>" alt="">
                            <?php elseif($v['cover']['title'] == '3d'):?>
                                <div class="custom_design case3d" style="background: white">
                                <?php else:?>
                            <div class="custom_design" style="background: white">
                            <?php endif;?>
                                <img class="case" src="<?=$urli?>/print/<?=$v['image']['name'].'.'.$v['image']['ext']?>" alt="">
                                <img class="mask_preview" src="<?=$urli?>/covers/<?=$v['producrt_cover_color_file_id']['name'].'.'.$v['producrt_cover_color_file_id']['ext']?>" alt="">
                                <svg class="sum" xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29">
                                    <circle fill="#2abe8b" cx="14.5" cy="14.5" r="14.5"></circle>
                                    <text fill="#fff" class="indicator" transform="translate(14 20)"><?= $v['count']?></text>
                                </svg>
                            </div>
                            <div class="details">
                                <h2><?= $v['product']['name']?></h2>
                                <p><?= $v['cover']['name']?></p>
                            </div>
                            <p class="price"><?=$v['total']?> ₴</p>
                            <?php
                            $sale = getSaleValue($v['product']['price'],$v['coupon']['discount_type'],$v['coupon']['value'],$v['count'],$sale);
                            ?>
                        <?php endforeach;?>
                    </ul>
                    <div class="total">
                        <?php if($cart[0]['coupon_id']):?>
                            <div class="discount">
                                <p class="rate"><?=Yii::t('frontend_order','Скидка')?> (<span><?= $cart[0]['coupon']['value'] ?> <?php echo ($cart[0]['coupon']['discount_type']==0) ? "%" : "₴"?></span>)</p>
                                <p class="currency"><span><?=$sale?></span> ₴</p>
                            </div>
                        <?php endif;?>
                        <div class="all">
                            <h2><?=Yii::t('frontend_order','итого')?>:</h2>
                            <strong><?=$sum?> ₴</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php endif;?>