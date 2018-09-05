<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 18.05.17
 * Time: 9:45
 */
$this->title = Yii::t('frontend_order','Оформление заказа');

$this->registerCssFile("@web/css/bycase.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/bycase.js",["depends" => 'frontend\assets\AppAsset']);

$phrases = [
    'order1' => Yii::t('frontend_order','Вы не выбрали вариант доставки или оплаты!'),
    'order2' => Yii::t('frontend_order','Вы не ввели адрес!'),
    'order3' => Yii::t('frontend_order','Вы не ввели телефон!'),
    'order4' => Yii::t('frontend_order','Заказ не найден'),
    'payment' => Yii::t('frontend_order','оплатить'),
];

$this->registerJs("var phrases = ".json_encode($phrases), \yii\web\View::POS_BEGIN);

$urli = \Yii::getAlias('@buploads');
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
//var_dump($delivery);
?>

<section class="content">
    <h1><?=Yii::t('frontend_order','оформление заказа')?></h1>
    <section>
        <?php if(\Yii::$app->getUser()->id):?>
                <?php if(!$cart):?>
                    <div class="message">
                        <p><?=Yii::t('frontend_order','Чтобы купить кейс, нужно его создать для начала!')?></p>
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
                <?php else:?>
                    <form class="container" action="#">
                        <div class="data">
                            <!-- Contacts -->
                            <div class="contacts">
                                <input type="text" placeholder="<?=Yii::t('frontend_order','Ваше имя')?>" value="<?=$user['username']?>">
                                <input type="tel" placeholder="<?=Yii::t('frontend_order','Телефон')?>" value="<?=$user['phone']?>">
                                <?php if(!empty($address[0]['address'])) :?>
                                    <input type="text" class="address" placeholder="<?=Yii::t('frontend_order','Адрес')?>" value="<?=$address[0]['address']?>">
                                <?php else:?>
                                    <input type="text" class="address" placeholder="<?=Yii::t('frontend_order','Адрес')?>" value="">
                                <?php endif;?>
                            </div>
                            <!-- Delivery and payment -->
                            <div class="params">
                                <!-- Delivery -->
                                <p><?=Yii::t('frontend_order','Варианты доставки')?></p>
                                <select name="delivery">
                                    <option disabled selected><?=Yii::t('frontend_order','Выберите вариант доставки')?></option>
                                    <?php foreach ($delivery as $v):?>
                                        <option value="<?=$v['id']?>"><?=$v['title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <input type="text" class="comment" placeholder="<?=Yii::t('frontend_order','Комментарий')?>">
                                <!-- Payment -->
                                <p><?=Yii::t('frontend_order','Варианты оплаты')?></p>
                                <select name="payment">
                                    <option disabled selected><?=Yii::t('frontend_order','Сделайте свой выбор...')?></option>
                                    <?php foreach ($payment as $v):?>
                                        <option value="<?=$v['id']?>"><?=$v['title']?></option>
                                    <?php endforeach;?>
                                </select>
                                <ul class="buttons">
                                    <li>
                                        <a class="next go_pay"><?=Yii::t('frontend_order','Оформить заказ')?></a>
                                    </li>
                                    <li>
                                        <a class="back" href="<?=\yii\helpers\Url::to(['/cart'])?>">
                                            <svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
                                                <path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
                                            </svg>
                                            <span><?=Yii::t('frontend_order','корзина')?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                    </form>

                <?php endif;?>
        <?php else:?>
            <div class="message">
                <p><?=Yii::t('frontend_order','Для начала нужно авторизоваться!')?></p>
            </div>
            <ul class="buttons">
                <li>
                    <button class="back" type="button" role="button" onclick="window.location.href='/order'">
                        <span><?=Yii::t('frontend_order','Авторизоваться')?></span>
                    </button>
                </li>
            </ul>
        <?php endif;?>

    </section>

</section>
<div class="pay">
    <div class="wrapper">
        <div class="notice">
            <button class="close" type="button"></button>
            <h2 class="title"><?=Yii::t('frontend_order','Выберите вариант оплаты:')?></h2>
            <div id="liqpa_form">

            </div>
            <!-- liqpay api response -->
            <a class="next" href="<?=\yii\helpers\Url::to(['/profile/index'])?>"><?=Yii::t('frontend_order','Оплатить позже')?></a>

        </div>
    </div>
</div>
