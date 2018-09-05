<?php

/* @var $this yii\web\View */

$this->title = 'ZaCase';
$this->registerJsFile("@web/js/slick/slick.min.js",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/main.js",["depends" => 'frontend\assets\AppAsset']);
$this->registerCssFile("@web/css/main.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerCssFile("@web/css/slick/slick.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerCssFile("@web/css/slick/slick-theme.css",["depends" => 'frontend\assets\AppAsset']);

//require ('../../../vendor/lis-dev/nova-poshta-api-2/src/')
//$np = new NovaPoshtaApi2('Ваш_ключ_API_2.0');
//var_dump( $mess);
//print_r($mess);
// Read image path, convert to base64 encoding

// Format the image SRC:  data:{mime};base64,{data};

//echo $src;
//// Echo out a sample image
//echo '<img src="'.$src.'">';
//var_dump($products);
$this->registerJs("window.products = ".json_encode($products).";
window.buploads = '".\Yii::getAlias('@buploads')."';",\yii\web\View::POS_BEGIN);

function getSales($sale) {
    return " (- ".$sale->value . ((!$sale->type) ? ' UAH' : "%"). ")";
}
?>
<div class="wrapper">
    <header>
        <div class="top">
            <?=\yii\helpers\Html::a('', ['/site/login'], ['class' => 'roundlink home'])?>
            <ul class="mode">
                <li><button class="big_btn phone selected"><?=Yii::t('frontend_site','Телефон')?></button></li>
                    <!--<li><button class="big_btn tablet">Планшет</button></li>-->
            </ul>
            <?=\yii\helpers\Html::a('', ['/cart'], ['class' => 'roundlink cart'])?>
        </div>
        <ul class="brands">
            <?php foreach ($labels as $v) {
                $sales = [];
                for ($i=0; $i<count($v['labelSales']); $i++) {
                    if(!empty($v['labelSales'][$i]->activeSale)) {
                        //first active sales;
                        $sales = $v['labelSales'][$i]->activeSale;
                        break;
                    }
                } ?>
                <li>
                    <a data-label-id="<?= $v['id']?>"><?= $v['name']. (!empty($sales) ? getSales($sales) : '')?> </a>
                </li>
            <?php } ?>
        </ul>
        <h1><?=Yii::t('frontend_site','выберите свой')?></h1>
    </header>
    <section>
        <div class="slider">
        </div>
    </section>
</div>