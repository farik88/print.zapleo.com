<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 12.05.17
 * Time: 10:29
 */

$this->title = Yii::t('frontend_cart','Корзина');
$this->registerCssFile("@web/css/cart.css",["depends" => 'frontend\assets\AppAsset']);
$this->registerJsFile("@web/js/cart.js",["depends" => 'frontend\assets\AppAsset']);

$phrases = [
    'cart1' => Yii::t('frontend_cart','Количество изменено'),
    'cart2' => Yii::t('frontend_cart','Произошла ошибка сохранения'),
    'cart3' => Yii::t('frontend_cart','Ошибка уменьшения количества! Стоит чуть подождать!'),
    'cart4' => Yii::t('frontend_cart','Вы дествительно хотите удалить товар из корзины?'),
    'cart5' => Yii::t('frontend_cart','Не удалено!'),
    'cart6' => Yii::t('frontend_cart','Ошибка удаления! Попробуйте позже'),
    'cart7' => Yii::t('frontend_cart','Купон не активен'),
];

$this->registerJs("var phrases = ".json_encode($phrases), \yii\web\View::POS_BEGIN);

$urli = \Yii::getAlias('@buploads');
$session = Yii::$app->session;

//@todo посмотри на это
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


function acceptSale($sale, $sum, $count) {
    //todo fix right define for count and percent
    if(!$sale['type']) {
        return $sale['value'];//$count * 
    }
    return ($sum*$sale['value'])/100;

}
function compareSale($sales, $total, $count) {
    $result = [];
    foreach($sales as $k=>$v) {
        if(empty($v)) {
            continue;
        }
        if(empty($result)) {
            $result = $v;
            $result['sale_val'] = acceptSale($result, $total, $count);
            continue;
        }
        if ($result['sale_val'] < ($tmpSaleVal = acceptSale($v, $total, $count))) {
            $result = $v;
            $result['sale_val'] = $tmpSaleVal;
        }
    }
    return $result;
}
function detectSale($cart, $price, $count) {
    $product = $cart['product'];
    $activeProductSale = $activeCoverSale = $activeLabelSale = [];
    if(!empty($product['productSales'])) {
        $activeProductSale = $product['productSales'][0]['activeSale'];
    }
    if(!empty($product['productLabels'])) {
        $label = $product['productLabels'][0]['label'];
        if(!empty($label['labelSales'])) {
            $activeLabelSale = $label['labelSales'][0]['activeSale'];
        }
    }
    $cover = $cart['cover'];
    if(!empty($cover['coverSales'])) {
        $activeCoverSale = $cover['coverSales'][0]['activeSale'];
    }

    return compareSale(
        compact('activeProductSale', 'activeLabelSale','activeCoverSale'),
        $price,
        $count
    );
}
?>

<?php if(!isset($cart) || empty($cart)):?>
<section class="content" style="padding: 0 2.4em">
	<h1><?=Yii::t('frontend_cart','корзина')?></h1>
	<section>
		<div class="message">
			<p><?=Yii::t('frontend_cart','У вас нет товаров в корзине')?></p>
		</div>
	</section>
	<ul class="buttons">
		<li>
			<button class="back" type="button" role="button" onclick="window.location.href='<?=\yii\helpers\Url::to(['/site/index'])?>'">
				<svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
					<path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
				</svg>
				<span><?=Yii::t('frontend_button','конструктор')?></span>
			</button>
		</li>
	</ul>
</section>

<?php else:?>
<section class="content">
	<h1><?=Yii::t('frontend_cart','корзина')?></h1>
	<div class="wrapper">
		<!-- Products -->
		<div class="products">
			<table>
				<thead>
				<tr class="title">
					<th class="big"><?=Yii::t('frontend_cart','товар')?></th>
					<th class="small"><?=Yii::t('frontend_cart','цена')?></th>
					<th class="small"><?=Yii::t('frontend_cart','всего')?></th>
				</tr>
				</thead>
				<tbody>
				<?php $globalSum = 0?>
				<?php foreach ($cart as $v):
					$biggestSale = detectSale($v, $v['product']['price'], $v['count'] );

					$price = $v['total'] -( ($biggestSale) ? $biggestSale['sale_val']:0);
					$endSum = $price * $v['count'];
					$globalSum += $endSum;

					?>

					<?php


					?>
						<tr data-cart-id="<?= $v['id']?>">
							<td class="product big">
								<?php if($v['cover']['title'] == '3d'):?>
									<div class="custom_design case3d">
								<?php else:?>
									<div class="custom_design">
								<?php endif;?>
									<?php if($v['cover']['title'] == 'silikon'):?>
										<img class="phone_preview" src="<?=$urli?>/colors/<?=$v['producrt_color_file_id']['name'].'.'.$v['producrt_color_file_id']['ext']?>" alt="">
									<?php endif;?>
									<img class="case" src="<?=$urli?>/print/<?=$v['image']['name'].'.'.$v['image']['ext']?>" alt="">
									<img class="mask_preview" src="<?=$urli?>/covers/<?=$v['producrt_cover_color_file_id']['name'].'.'.$v['producrt_cover_color_file_id']['ext']?>" alt="">
								</div>
								<div class="details">
									<h2><?= $v['product']['name']?></h2>
									<p><?= $v['cover']['name']?></p>
									<table class="amt">
										<tbody>
										<tr>
											<td>
												<button class="dec" type="button">–</button>
											</td>
											<td><output><?=$v['count']?></output></td>
											<td>
												<button class="inc" type="button">+</button>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</td>
							<td class="small"><strong><?=$v['total']/$v['count']?> ₴</strong></td>
							<td class="small">
								<strong class="total_price"><span><?=$v['total']?></span> ₴</strong>
								<button class="remove" type="button" rel="button">
									<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" style="width:100%;height:auto;">
										<text fill="#fff" style="font-size:12px" transform="translate(14.7 19.7)">х</text>
									</svg>
								</button>
							</td>
						</tr>
					<?php
					$sale = getSaleValue($v['product']['price'],$v['coupon']['discount_type'],$v['coupon']['value'],$v['count'],$sale);
					?>
				<?php endforeach;?>

				<!-- Second item -->

				</tbody>
			</table>
		</div>
		<!-- Total -->
		<div class="total">

				<?php if($cart[0]['coupon_id']):?>
					<div class="discount">
						<p class="rate"><?=Yii::t('frontend_cart','Скидка')?> (<span><?= $cart[0]['coupon']['value'] ?> <?php echo ($cart[0]['coupon']['discount_type']==0) ? "%" : "₴"?></span>)</p>
						<p class="currency"><span><?=$sale?></span> ₴</p>
					</div>

					<?php else:?>
					<p>
						<input type="text" class="coupon_hash" placeholder="<?=Yii::t('frontend_cart','Введите промо-код')?>">
						<button type="button" class="coupon"><?=Yii::t('frontend_cart','Применить')?></button>
					</p>
				<?php endif;?>


			<div class="all">
				<h2><?=Yii::t('frontend_cart','итого')?>:</h2>
				<strong><?=$sum?> ₴</strong>
			</div>
		</div>
		<!-- Buttons -->
		<ul class="buttons">
			<li>
				<button class="next" type="button" onclick="window.location.href='<?=\yii\helpers\Url::to(['/order/index'])?>'" role="button"><?=Yii::t('frontend_cart','оформить заказ')?></button>
			</li>
			<li>
				<button class="back" type="button" role="button" onclick="window.location.href='<?=\yii\helpers\Url::to(['/site/index'])?>'">
					<svg class="back_arr" xmlns="http://www.w3.org/2000/svg" width="30.25" height="18" viewBox="0 0 30.25 18">
						<path fill="#979797" d="M29.78 7.03a1.52 1.52 0 0 0-1.2-.53H9.28l2.32-2.32a1.82 1.82 0 0 0 0-2.6L10.53.55a1.8 1.8 0 0 0-2.58 0l-7.4 7.4A1.82 1.82 0 0 0 0 9.24a1.74 1.74 0 0 0 .54 1.28l7.18 6.96a1.82 1.82 0 0 0 1.3.53 1.74 1.74 0 0 0 1.28-.52l1.07-1.08a1.94 1.94 0 0 0 0-2.1L9.3 11.97h19.3a1.52 1.52 0 0 0 1.2-.53 1.9 1.9 0 0 0 .45-1.3v-1.8a1.9 1.9 0 0 0-.47-1.3z"></path>
					</svg>
					<span><?=Yii::t('frontend_button','конструктор')?></span>
				</button>
			</li>
		</ul>
	</div>
</section>

<?php endif;?>