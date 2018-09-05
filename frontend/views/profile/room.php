<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 15.05.17
 * Time: 13:17
 */
$this->title = Yii::t('frontend_profile','Профиль');
$this->registerCssFile("@web/css/room.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/room.js",["depends" => 'frontend\assets\AppAsset']);
$urli = \Yii::getAlias('@buploads');
//var_dump($order);

$phrases = [
    'payment' => Yii::t('frontend_profile','оплатить')
];

$this->registerJs("window.order_prod = ".json_encode($order_prod).";
window.order = ".json_encode($order).";
window.buploads = '".\Yii::getAlias('@buploads')."';
var phrases = ".json_encode($phrases), \yii\web\View::POS_BEGIN);

function getButtons() {
    ?>
    <button class="save" type="button"></button>
    <button class="edit" type="button"></button>
    <?php
}

function getAddressBlock($id = null, $value = null ) {
    ?>
    <p>
        <label >
            <?php if($id && $value) : ?>
            <input name="address" data-address-id="<?=$id?>" class="adres" type="text" value="<?=$value?>" disabled="">
           <?php else:?>
            <input name="address" class="add_address" type="text" value="" disabled="">
            <?php endif;?>
            <?php getButtons() ?>
        </label>
    </p>
<?php
}
?>
<section class="content">
    <?=\yii\helpers\Html::a(Yii::t('frontend_profile','Выход'), ['/site/logout'], ['class' => 'exit', 'data-method' => 'post'])?>
<!--    <button type="button" onclick="window.location.href='/site/logout'">Выход</button>-->
    <h1><?=Yii::t('frontend_profile','добро пожаловать')?>, <span  class="username"><?= $model->username?></span></h1>
    <div class="wrapper">
        <!-- Info -->
        <div class="info">
            <h2><?=Yii::t('frontend_profile','ваша информация')?></h2>
            <p>
                <span><?=Yii::t('frontend_profile','Ваше имя')?></span>
                <label for="username">
                    <input name="username" data-type-value="username" id="username" type="text" value="<?= $model->username?>" disabled>
                    <?php getButtons() ?>
                </label>
            </p>
            <p>
                <span><?=Yii::t('frontend_profile','Ваш email')?></span>
                <label for="usermail">
                    <input name="email" data-type-value="useremail" id="usermail" type="email" value="<?= $model->email?>" disabled>
                    <?php getButtons() ?>
                </label>
            </p>
            <p>
                <span><?=Yii::t('frontend_profile','Заказы')?></span>
                <output name="orders"><?=$c_order?></output>
            </p>
            <p>
                <span><?=Yii::t('frontend_profile','Всего потрачено')?></span>
                <output name="sum"><?=(int) $sum?> ₴</output>
            </p>
        </div>
        <!-- Addresses -->
        <div class="address">
            <h2><?=Yii::t('frontend_profile','ваши адреса')?></h2>
            <?php if(!$address):?>
                <?php getAddressBlock(); ?>
                <?php getAddressBlock(); ?>
                <?php elseif (count($address) == 1):?>
                <?php getAddressBlock(); ?>
            <?php endif;?>
            <?php foreach ($address as $v):?>
                <?php getAddressBlock($v['id'], $v['address']); ?>
            <?php endforeach;?>
        </div>
        <!-- Orders list -->
        <div class="orders">
            <h2><?=Yii::t('frontend_profile','ваши заказы')?></h2>
            <?php if($c_order == 0):?>
                <div class="message">
                    <p><?=Yii::t('frontend_profile','У вас пока нет ни одного заказа')?></p>
                </div>
            <?php endif;?>
            <ul class="orders-list">
                <?php foreach ($order_prod as $v):?>
                    <?php foreach ($v as $val):?>
                        <li>
                            <div class="container">
                                <?php if($val['cover']['title'] == '3d'):?>
                                <div class="custom_design case3d">
                                    <?php else:?>
                                        <div class="custom_design">
                                    <?php endif;?>
                                    <?php if($val['cover']['title'] == 'silikon'):?>
                                        <img class="phone_preview" src="<?=$urli?>/colors/<?=$val['producrt_color_file_id']['name'].'.'.$val['producrt_color_file_id']['ext']?>" alt="">
                                    <?php endif;?>
                                    <img class="case" src="<?=$urli?>/print/<?=$val['image']['name'].'.'.$val['image']['ext']?>" alt="">
                                    <img class="mask_preview" src="<?=$urli?>/covers/<?=$val['producrt_cover_color_file_id']['name'].'.'.$val['producrt_cover_color_file_id']['ext']?>" alt="">
                                </div>
                                <div class="details">
                                    <h3><?=Yii::t('frontend_profile','Заказ')?> №<?= $val['order_id']?>, <?= date("j F Y H:i ", $val['created_at'])?></h3>
                                    <p><?= $val['product']['name']?></p>
                                    <p><?= $val['cover']['name']?></p>
                                    <p><?= (int) $val['count']?></p>
                                    <p><?= (int) $val['total']?> ₴</p>
                                    <div class="liqpa_form">
                                        <?php if(intval($val['order']['status_payment']) !== \common\models\Orders::PAYMENT_ACCEPTED):?>
                                            <button class="pay_now back" data-order-id="<?= $val['order_id']?>"><?=Yii::t('frontend_profile','оплатить сейчас')?></button>
                                            <?php else:?>
                                            <p><?=Yii::t('frontend_profile','Статус: Оплачено')?></p>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;?>
                <?php endforeach;?>
            </ul>
        </div>
        <ul class="buttons">
            <li>
                <a class="back" href="<?=\yii\helpers\Url::to(['/site/index'])?>">
                    <svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
                        <path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
                    </svg>
                    <span><?=Yii::t('frontend_button','конструктор')?></span>
                </a>
            </li>
        </ul>
    </div>
</section>

<div class="pay">
    <div class="wrapper">
        <div class="notice">
            <button class="close" type="button"></button>
            <h2 class="title"><?=Yii::t('frontend_profile','Выберите вариант оплаты')?>:</h2>
            <div id="liqpa_form">

            </div>
        </div>
    </div>
</div>