<?php
use \common\services\Instagram;
use \common\models\base\Folders;
use frontend\assets\ShepherdAsset;
use yii\web\View;
use mootensai\components\JsBlock;

$urli = \Yii::getAlias('@buploads');

$smile_path=[];
foreach ($smile as $v){
    if($v['folder']['type_id'] == Folders::TYPE_EMOJI){
        $smile_path['emoji'][] = $urli.'/resources/emoji/'.$v['folder']['name'].'/'.$v['name'].'.'.$v['ext'];
    }else if($v['folder']['type_id'] == Folders::TYPE_BACKGROUND){
        $smile_path['background'][] = $urli.'/resources/background/'.$v['folder']['name'].'/'.$v['name'].'.'.$v['ext'];
    }
}
$this->title = Yii::t('frontend_site','Конструктор');

$this->registerJsFile("@web/js/fabric.min.js",["depends" => 'frontend\assets\AppAsset']);
$this->registerCssFile("@web/css/secondapp.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerCssFile("@web/css/left_section.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/secondapp.js",["depends" => 'frontend\assets\AppAsset']);
/* Help tour */
$tour_texts = [
    'step-1' => Yii::t('frontend_constructor_helper', 'Это крутой конструктор'),
    'step-2' => Yii::t('frontend_constructor_helper', 'На этой вкладке Вы можете выбрать разметку, которая поможет красиво расположить изображения на чехле телефона'),
    'step-3' => Yii::t('frontend_constructor_helper', 'Тут вы можете загрузить собственное изображение c устройства или Instagram аккаунта и использовать его в создании принта'),
    'step-4' => Yii::t('frontend_constructor_helper', 'Так же во вкладке Дизайн Вы можете вы можете найти интересные картинки из нашей библиотеки'),
    'step-5' => Yii::t('frontend_constructor_helper', 'Прикольные смайлики :)'),
    'step-6' => Yii::t('frontend_constructor_helper', 'А так же Вы можете разместить любой текст на чехле!'),
    'step-7' => Yii::t('frontend_constructor_helper', 'Тут можно изменить цвет Вашего телефона'),
    'step-8' => Yii::t('frontend_constructor_helper', 'Накидать случайных изображений...'),
    'step-9' => Yii::t('frontend_constructor_helper', 'Очистить все изображения...'),
    'step-10' => Yii::t('frontend_constructor_helper', 'Удалить выбранное изображение...'),
    'step-11' => Yii::t('frontend_constructor_helper', 'Переместить слой...'),
    'step-12' => Yii::t('frontend_constructor_helper', 'На этом все. Enjoy!'),
];
if($need_to_show_help){
    ShepherdAsset::register($this);
    JsBlock::widget(['viewFile' => '_help-tour', 'pos'=> View::POS_END, 'viewParams' => [
        'product' => $product,
        'tour_texts' => $tour_texts,
    ]]);
}

$phrases = [
    'site1' => Yii::t('frontend_create','Вы не вошли в аккаунт!'),
    'site2' => Yii::t('frontend_create','Неизвестный формат изображения!'),
    'site3' => Yii::t('frontend_create','Введите ваш текст'),
    'site4' => Yii::t('frontend_create','Сначала выберите текст'),
    'site5' => Yii::t('frontend_create','Вы уверены что хотите удалить обьект?'),
    'site6' => Yii::t('frontend_create','Вы уверены что хотите удалить группу обьектов?'),
    'site7' => Yii::t('frontend_create','Выберите обьект'),
    'site8' => Yii::t('frontend_create','Вы уверены что хотите удалить все обьекты?'),
    'site9' => Yii::t('frontend_create','Ваш текст'),
    'site10' => Yii::t('frontend_create','Произошла ошибка сохранения!'),
];

$this->registerJs("window.product = JSON.parse('".json_encode($product)."');
window.colors = JSON.parse('".json_encode($colors)."');
window.smile_path = JSON.parse('".json_encode($smile_path)."');
window.buploads = '".\Yii::getAlias('@buploads')."';
var phrases = ".json_encode($phrases),\yii\web\View::POS_BEGIN);

//var_dump($colors);
//var_dump($bac_foldes);
//var_dump($covers);
//var_dump($smile);

?>
<script>
    var instaProfile = <?=json_encode(Instagram::hasUserInfo())?>;
</script>
<style>
    <?php foreach ($fonts as $v):?>
    @font-face {
        font-family: "<?= $v['name']?>";
        font-style: normal;
        font-weight: normal;
    <?php if($v['ext'] == 'ttf'):?>
        src: url("<?= $urli?>/resources/fonts/<?= $v['name']?>.<?=$v['ext']?>") format("truetype");
    <?php else:?>
        src: url("<?= $urli?>/resources/fonts/<?= $v['name']?>.<?=$v['ext']?>") format("woff");
    <?php endif;?>
    }
    <?php endforeach;?>
</style>
<section>
    <a href="<?=\yii\helpers\Url::to(['/site/index'])?>" class="logo">
        <img class="" src="/img/logo.svg" alt="logo">
    </a>
    <button type="button" class="profile" title="<?=Yii::t('frontend_site','Профиль')?>" onclick="window.location.href='/site/login'"></button>
    <div class="device-desc">
        <h1><?= $product['name'] ?></h1>
        <p class="name_cover"><?= $covers[0]['name']?></p>
        <h2><?= $product['price'] - $discount?> ₴</h2>
    </div>
    <div class="controls">
        <ul>
            <li>
                <button type="button" class="profile" title="<?=Yii::t('frontend_site','Профиль')?>" onclick="window.location.href='/site/login'"></button>
<!--            <li>-->
<!--                <button type="button" class="book" onclick="window.location.href='/site/faq'"></button>-->
            <li>
                <button type="button" class="shuffle" title="<?=Yii::t('frontend_site','Случайно')?>"></button>
            <li>
                <button type="button" class="reset" title="<?=Yii::t('frontend_site','Очистить все')?>"></button>
            <li>
                <button type="button" class="remove" title="<?=Yii::t('frontend_site','Удалить')?>"></button>
        </ul>
    </div>
    <div class="colorset">
        <ul>
            <?php for ($i = 0 ; $i < count($colors); $i++):?>
            <li class="color_file" data-color-id="<?= $colors[$i]['color']['id']?>" data-color-file-id="<?= $colors[$i]['file_id']?>">
                <label for="color<?= $i ?>">
                    <?= $colors[$i]['color']['name']?><span style="background:<?= $colors[$i]['color']['code'] ?>"></span>
                </label>
                <input id="color<?= $i ?>" name="colorset" type="radio">
                <?php endfor;?>
        </ul>
    </div>
</section>

<div data-product-id="<?= $product['id']?> " style="
        width: <?= $product['wspace_width'].'px'?>;
        height: <?=$product['wspace_height'].'px'?>;
        " class="container canvas-block">
    <img class="phone-mask" src="/images/silikonblak.png" alt="">
    <img class="helper-mask" src="" alt="">
    <canvas width="<?= $product['wspace_width']?>" height="<?=$product['wspace_height']?>" id="canvas"></canvas>
</div>
<!--<img src="/images/smile2.svg" class="smile img-thumbnail" alt="">-->
<!-- Sidebar -->
<aside class="sidebar">
    <!-- Z-index control button -->
    <button type="button" title="<?=Yii::t('frontend_site','Переместить слой')?>" class="zindex"></button>
    <!-- Color select block -->

    <header>
        <div class="progressbar">
            <ol>
                <li onclick="window.location.href='<?=\yii\helpers\Url::to(['/site/index'])?>'">
                    <svg class="stage1 completed" xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42">
                        <path d="M20.66 0A20.67 20.67 0 1 1-.02 20.65 20.68 20.68 0 0 1 20.66 0z" class="corner"/>
                        <circle cx="20.66" cy="20.66" r="18.91" class="bgfill"/>
                        <text class="num" transform="translate(20.5 30)scale(1.745)">1</text>
                    </svg>

                    <p><?=Yii::t('frontend_site','Устройство')?></p>
                </li>
                <li class="case_part">
                    <svg class="stage2 completed" xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42">
                        <path d="M20.66 0A20.67 20.67 0 1 1-.02 20.65 20.68 20.68 0 0 1 20.66 0z" class="corner"/>
                        <circle cx="20.66" cy="20.66" r="18.91" class="bgfill"/>
                        <text class="num" transform="translate(20.5 30)scale(1.745)">2</text>
                    </svg>
                    <p><?=Yii::t('frontend_site','Чехол')?></p>
                </li >
                <li class="case_design">
                    <svg class="stage3" xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42">
                        <path d="M20.66 0A20.67 20.67 0 1 1-.02 20.65 20.68 20.68 0 0 1 20.66 0z" class="corner"/>
                        <circle cx="20.66" cy="20.66" r="18.91" class="bgfill"/>
                        <text class="num" transform="translate(20.5 30)scale(1.745)">3</text>
                    </svg>
                    <p><?=Yii::t('frontend_site','Дизайн')?></p>
                </li>
            </ol>
            <!-- Control line width with JS $('.line span').width() -->
            <p class="line"><span style="width:50%;"></span></p>
        </div>
    </header>
    <!-- Case type -->
    <div class="case_type">
        <ul>
            <?php foreach ($covers as $v) :?>
                <?php if ($v['active'] == \common\models\Covers::COVER_ACTIVE):?>
                <li class="sale" data-cover-title="<?= $v['title']?>" data-cover-id="<?=$v['id']?>">
                    <img src="<?=$urli.'/'.$v['file']['name'].'.'.$v['file']['ext']?>" alt="">
                    <p><?= $v['name']?></p>
                    <?php
                    if(!empty($v['coverSales']) && !empty($v['coverSales'][0]['activeSale'])):
                        $sale = $v['coverSales'][0]['activeSale'];
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60">
                        <path d="M0 30.17A30.17 30.17 0 1 0 30.16 0 30.2 30.2 0 0 0 0 30.17zm2.4 0a27.75 27.75 0 1 1 27.76 27.75A27.78 27.78 0 0 1 2.4 30.17z"></path>
                        <text fill="#333" transform="translate(30.4 36) scale(1)">- <?=$sale['value']?> <?=$sale['type_text']?></text>
                    </svg>
                    <?php endif;?>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
    <!-- Constructor -->
    <div class="constructor">
        <div class="tabs">
            <input type="radio" name="maintabs" value="1" id="tab1" checked>
            <label for="tab1">
                <span><?=Yii::t('frontend_site','Разметка')?></span>
            </label>
            <input type="radio" name="maintabs" value="2" id="tab2">
            <label for="tab2">
                <span><?=Yii::t('frontend_site','Изображение')?></span>
            </label>
            <input type="radio" name="maintabs" value="3" id="tab3">
            <label for="tab3">
                <span><?=Yii::t('frontend_site','Дизайн')?></span>
            </label>
            <!-- Grid variants -->
            <div class="grid">
                <ul>
                    <?php foreach ($markings as $v):?>
                    <li class="marking">
                        <svg viewBox="0 0 62 100">
                            <path d="M0 0h62.06v100.7H0V0zm9 3.56h8.75a3.98 3.98 0 1 1 0 7.96H9a3.98 3.98 0 1 1 0-7.96z"/>
                            <image x="0" y="0" width="62" height="100" xlink:href="<?= $urli.'/markings/'. $v['name']?>" />
                        </svg>
                    <?php endforeach;?>

                </ul>
            </div>
            <!-- Image -->
            <div class="image">
				<div class="buttons">
					<button class="upload any" type="button" role="button">
						<img src="/img/upload.svg" alt="↑">
						<span><?=Yii::t('frontend_site','Загрузить из ПК')?></span>
					</button>
	<!--                <input id="upload" type="file" name="photo[]" accept="image/*,image/jpeg,image/png" multiple>-->
	<!--                <label for="upload" class="upload">-->
	<!--                    <img src="/img/upload.svg" alt="&uarr;">-->
	<!--                    <span>Загрузить</span>-->
	<!--                </label>-->
					<button class="upload inst" type="button">
						<img src="/img/inst_icon.png" alt="">
						<span><?=Yii::t('frontend_site','Загрузить из Instagram')?></span>
					</button>
				</div>
                <div class="manual">
                    <div class="profiles">
                        <input id="upload" type="file" name="photo[]" accept="image/*,image/jpeg,image/png" multiple>
                        <label for="upload" class="upload">
                            <!--<img src="img/upload.svg" alt="↑">-->
                            <span><?=Yii::t('frontend_site','Выбрать')?></span>
                        </label>
<!--                        <button type="button" class="by_link" onclick="this.classList.toggle('active')">-->
                            <!--<img src="" alt="">-->
<!--                            <span>По ссылке</span>-->
<!--                        </button>-->
                        <!-- Uploaded images -->
                        <ul class="uploaded">
                            <li>
                                <img src="https://static.greatbigcanvas.com/images/square/raygun/new-york-city-skyline-at-night,2417942.jpg" alt="">
                                <button type="button"></button>
                            </li><li>
                                <img src="https://static.greatbigcanvas.com/images/square/getty-images/silhouette-red-trees-upward,1959107.jpg" alt="">
                                <button type="button"></button>
                            </li><li>
                                <img src="https://static.greatbigcanvas.com/images/square/alaska-stock/close-up-of-multi-colored-stones,akseaew0001.jpg" alt="">
                                <button type="button"></button>
                            </li><li>
                                <img src="https://static.greatbigcanvas.com/images/square/panoramic-images/buildings-lit-up-at-night-la-giralda-kansas-city-missouri,41623.jpg" alt="">
                                <button type="button"></button>
                            </li></ul>
                        <!-- Search form -->
                        <form method="get" class="search-link" action="#">
                            <input type="search" name="search" placeholder="<?=Yii::t('frontend_site','Поиск')?>">
                            <button type="submit" class="magn"></button>
                        </form>
                    </div>
                    <!-- Uploaded images from PC -->
                    <ul id="upl-image-container" class="uploaded "></ul>
                    <!-- Upload via Instagram -->
                </div>

                <div class="instagram">
                    <div class="profiles">
                        <?php
                        if(! ($token = Instagram::hasAccessToken())):
                        ?>
                            <div class ="instaLogin"><a target="_blank" href="<?=(new Instagram())->getLoginUrl()?>"><span><?=Yii::t('frontend_site','Войти')?></span></a></div>
                        <?php endif;?>
                                <button type="button" class="my_pr instaLoad <?=(!$token) ? 'hide' : ''?>">
<!--                                    <img src="https://pp.userapi.com/c629412/v629412892/2afc/UwTfkMssoHw.jpg" alt="">-->
                                    <a href="#"><span><?=Yii::t('frontend_site','Ваш профиль')?></span></a>
                                </button>
<!--                                <button type="button" class="other_pr instaLoad --><?//=(!$token) ? 'hide' : ''?><!--">-->
<!--                                    <img src="/img/other_profile.svg" alt="">-->
<!--                                    <a href="#"><span>Другой профиль</span></a>-->
<!--                                </button>-->

                        <!-- Search form -->
                        <div class="search-insta" >
                            <input class='user-tag' type="text">
                            <button class="magn"></button>
                        </div>

                        <!-- Uploaded from my Instagram -->
                        <ul class="uploaded" id="insta-image-container"></ul>

                    </div>
                </div>
            </div>
            <!-- Design -->
            <div class="design">
                <input type="radio" name="designtabs" value="4" id="tab4" checked>
                <label class="activeti" data-type-id="2" for="tab4">
                    <span>Фон</span>
                </label>
                <input type="radio" name="designtabs" value="5" id="tab5">
                <label data-type-id="0" for="tab5">
                    <span>EMOJI</span>
                </label>
                <input type="radio" name="designtabs" value="6" id="tab6">
                <label data-type-id="2" for="tab6">
                    <span>Текст</span>
                </label>
                <!-- Backgrounds -->
                <!-- Categories -->
                <ul class="bg_categories">
                    <?php foreach ($backgroundFolders as $v):?>
                        <li class="fon_click" data-type-id="<?=$v['type_id']?>" data-folder-id="<?=$v['id']?>"><?=$v['name']?>
                    <?php endforeach;?>
                </ul>
                <!-- Categories -->
                <div class="backgrounds">
                    <!-- Control bar -->
                    <div class="zoom_bar clearfix">
                        <button type="button" class="return return_background"><img src="/img/arr_back.svg" alt="&larr;"><?=Yii::t('frontend_site','Назад')?></button>
                        <strong class="title"></strong>
                        <p class="range">
                            <button class="dec" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <circle fill="#333" cx="15.9" cy="15.9" r="15.9"/>
                                    <circle class="bgfill" cx="15.9" cy="15.9" r="13.9"/>
                                    <text fill="#333" transform="translate(15.4 23.5)scale(1.7)">-</text>
                                </svg>
                            </button>
                            <input type="range" min="-3" max="3" value="0">
                            <button class="inc" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <circle fill="#333" cx="15.9" cy="15.9" r="15.9"/>
                                    <circle class="bgfill" cx="15.9" cy="15.9" r="13.9"/>
                                    <text fill="#333" transform="translate(15.4 24.685)scale(1.7)">+</text>
                                </svg>
                            </button>
                        </p>
                    </div>
                    <!-- Background images -->
                    <ul class="bg_container">
<!--                        <li><img class="smile" src="http://zap.im.biz.ua/images/fone/2.png" alt="">-->
                    </ul>
                </div>
                <!-- EMOJI categories -->
                <ul class="emoji_categories">
                    <?php foreach ($emoji as $v):?>
                    <li class="emoji_click" data-type-id="<?=$v['type_id']?>" data-folder-id="<?=$v['id']?>"><?=$v['name']?>
                        <?php endforeach;?>
                </ul>
                <!-- Text tab -->
                <div class="text">
                    <p><strong><?=Yii::t('frontend_site','Ваша фраза')?></strong></p>
                    <form action="#">
                        <textarea id="text" name="phrase" rows="4" placeholder="example"></textarea>
                        <!-- Color choise panel -->
                        <ul class="colors clearfix">
                            <li>
                                <input id="976b01" name="color" type="radio">
                                <label for="976b01" style="background:#976b01"></label>
                            <li>
                                <input id="3498db" name="color" type="radio">
                                <label for="3498db" style="background:#3498db"></label>
                            <li>
                                <input id="2ecc71" name="color" type="radio">
                                <label for="2ecc71" style="background:#2ecc71"></label>
                            <li>
                                <input id="f1c40f" name="color" type="radio">
                                <label for="f1c40f" style="background:#f1c40f"></label>
                            <li>
                                <input id="f613d9" name="color" type="radio">
                                <label for="f613d9" style="background:#f613d9"></label>
                            <li>
                                <input id="3ad6e4" name="color" type="radio">
                                <label for="3ad6e4" style="background:#3ad6e4"></label>
                            <li>
                                <input id="black" name="color" type="radio">
                                <label for="black" style="background:black"></label>
                            <li>
                                <input id="818080" name="color" type="radio">
                                <label for="818080" style=" background:#818080"></label>
                            <li>
                                <input id="ffffff" name="color" type="radio">
                                <label for="ffffff" style="background:#ffffff"></label>
                            <li>
                                <input id="e74c3c" name="color" type="radio">
                                <label for="e74c3c" style="background:#e74c3c"></label>
                            <li>
                                <input id="e67e22" name="color" type="radio">
                                <label for="e67e22" style="background:#e67e22"></label>
                            <li>
                                <input id="bdc3c7" name="color" type="radio">
                                <label for="bdc3c7" style="background:#bdc3c7"></label>
                            <li>
                                <input id="1abc9c" name="color" type="radio">
                                <label for="1abc9c" style="background:#1abc9c"></label>
                            <li>
                                <input id="f39c12" name="color" type="radio">
                                <label for="f39c12" style="background:#f39c12"></label>
                        </ul>

                        <!-- Setting font-family -->
                        <p><strong><?=Yii::t('frontend_site','Стиль шрифта')?></strong></p>
                        <ul class="fonts">
                            <?php foreach ($fonts as $v):?>
                            <li class="fontsfamily" data-font-type="<?=$v['name']?>" style="font-family:'<?=$v['name']?>'">
                                <input id="font<?=$v['id']?>" type="radio" name="fonts"><label for="font<?=$v['id']?>"><?= $v['name']?></label>
                            <?php endforeach;?>
                        </ul>
                        <!-- Setting font-size -->
<!--                        <p><strong>Размер шрифта</strong></p>-->
                        <div>
<!--                            <input id="fontsize" type="number" min="1" max="100" value="30">-->
                            <button type="button" class="addtext"><?=Yii::t('frontend_site','Добавить текст')?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="add_button_this">
        <button type="button" class="back"><?=Yii::t('frontend_site','Назад')?></button>
        <button type="button" class="done"><?=Yii::t('frontend_site','готово')?></button>
    </footer>

    <button type="button" class="mob_constr"></button>
</aside>

<button type="button" class="zindex"></button>

<div class="success">
    <div class="wrapper">
        <div class="notice">
            <button class="close" type="button"></button>
            <h2 class="congrats"><?=Yii::t('frontend_site','Вы успешно добавили свой')?><br><?=Yii::t('frontend_site','дизайн в корзину')?></h2>
            <figure>
                <div class="custom_design">
                    <img class="phone_preview" src="" alt=""><!--phone-->
                    <img class="case" src="" alt=""><!-- canvas.toDataURL('png') -->
                    <img class="mask_preview" src="" alt=""><!--mask-->
                </div>
                <figcaption>
                    <h1><?= $product['name'];?></h1>
                    <p></p>
                    <h2 class="price"><?= $product['price'] - $discount;?> ₴</h2>
                </figcaption>
            </figure>
            <footer>
                <a href="<?=\yii\helpers\Url::to(['/site/index'])?>" class="back">
                    <svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
                        <path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
                    </svg><?=Yii::t('frontend_button','конструктор')?>
				</a>
                <a class="next add_cart" href="#"><?=Yii::t('frontend_site','в корзину')?></a>
            </footer>
        </div>
    </div>
</div>

<!-- Preloader -->
<div class="preloader">
	<svg class="spinner" xmlns="http://www.w3.org/2000/svg" width="120px" height="120px" viewBox="0 0 128 128" xml:space="preserve">
		<g>
			<path class="filled" d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(45 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(90 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(135 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(180 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(225 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(270 64 64)"/>
			<path d="M38.52 33.37L21.36 16.2A63.6 63.6 0 0 1 59.5.16v24.3a39.5 39.5 0 0 0-20.98 8.92z" transform="rotate(315 64 64)"/>
			<animateTransform attributeName="transform" type="rotate" values="0 64 64;45 64 64;90 64 64;135 64 64;180 64 64;225 64 64;270 64 64;315 64 64" calcMode="discrete" dur="1160ms" repeatCount="indefinite"></animateTransform>
		</g>
	</svg>
</div>

<div id="dark-master">
    <canvas height="100" width="100" id="dark-master-canvas"></canvas>
</div>