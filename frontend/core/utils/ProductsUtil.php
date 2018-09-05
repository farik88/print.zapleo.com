<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 15.05.17
 * Time: 14:50
 */

namespace frontend\core\utils;
use common\models\Covers;
use common\models\Folders;
use common\models\Labels;
use common\models\Markings;
use common\models\ProductColor;
use common\models\ProductCover;
use common\models\Products;
use common\models\Resources;
use common\traits\SessionTrait;
use yii;

/**
 * Class ProductsUtil
 * @package frontend\core\utils
 */
class ProductsUtil extends BaseUtil
{
    use SessionTrait;

    /**
     * @param $productId
     * @return array|null|yii\db\ActiveRecord
     */
    protected function getProduct($productId) {
        $product = Products::find()
            ->with('file','productLabels', 'productLabels',
                'productLabels.label', 'productLabels.label.labelSales',
                'productLabels.label.labelSales.activeSale',
                'productSales','productSales.activeSale')
            ->where([ 'id' => $productId ])
            ->asArray()
            ->one();

        $product['name'] = \Yii::t('backend_products_name', $product['name']);

        return $product;
    }

    /**
     * @param $productId
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getProductColor($productId) {
        $colors = ProductColor::find()
            ->with('color','file')
            ->where([ 'product_id' => $productId ])
            ->asArray()
            ->all();

        // Translate covers name
        foreach ($colors as $i => $color)
            $colors[$i]['color']['name'] = \Yii::t('backend_colors_name', $colors[$i]['color']['name']);

        return $colors;
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getCovers() {
        $covers = Covers::find()
            ->with('file','coverSales.activeSale')
            ->asArray()
            ->all();

        // Translate covers name
        foreach ($covers as $i => $cover)
            $covers[$i]['name'] = \Yii::t('backend_covers_name', $covers[$i]['name']);

        return $covers;
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getBgFolders() {
        $folders = Folders::find()
            ->where([ 'type_id' => Folders::FT_BACKGROUNDS ])
            ->asArray()
            ->all();

        // Translate covers name
        foreach ($folders as $i => $folder)
            $folders[$i]['name'] = \Yii::t('backend_folders_name', $folders[$i]['name']);

        return $folders;
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getEmoji(){
        $folders = Folders::find()
            ->where([ 'type_id' => Folders::FT_EMOJI ])
            ->asArray()
            ->all();

        // Translate covers name
        foreach ($folders as $i => $folder)
            $folders[$i]['name'] = \Yii::t('backend_folders_name', $folders[$i]['name']);

        return $folders;
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getMarkings() {
        return Markings::find()->asArray()->all();
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getFonts() {
        return Resources::find()
            ->where([ 'folder_id' => null ])
            ->asArray()
            ->all();
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    protected function getAllSmile(){
        return Resources::find()
            ->where('folder_id IS NOT NULL')
            ->with('folder')
            ->asArray()
            ->all();
    }

    /**
     * @return string
     */
    public function genUserHash() {
        return Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * @param $productId
     * @return array
     */
    public function getCreationParams($productId) {
        //$url_file = Files::findOne($product->file_id);
        $product = $this->getProduct($productId);
        $salesUtil = new SalesUtil();
        $productSale = $salesUtil->getSaleByProduct($product);
        $discount = $labelDiscount = 0;
        if($productSale) {
            $discount = $salesUtil->acceptSale($productSale, $product['price'], 1);
        }

        $labelsSale = $salesUtil->getSaleByLabel($product['productLabels'][0]['label']);
        if($labelsSale) {
            $labelDiscount = $salesUtil->acceptSale($labelsSale,  $product['price'],1);
        }
        if($labelDiscount > $discount) {
            $discount = $labelDiscount;
        }
        $colors = $this->getProductColor($productId);
        $covers = $this->getCovers();
        $backgroundFolders = $this->getBgFolders();
        $emoji = $this->getEmoji();
        $markings = $this->getMarkings();
        $fonts = $this->getFonts();
        $smile = $this->getAllSmile();
        if (!$this->getFromSession('id')){
            // todo remove to other class, user for example
            $this->setToSession("id", $this->genUserHash());
        }
        $need_to_show_help = (!isset(Yii::$app->request->cookies['help_was_read']) && !$this::is_mobile()) ? true : false;
        return compact('product','discount', 'colors', 'covers', 'backgroundFolders', 'emoji', 'markings', 'fonts','smile', 'need_to_show_help');
    }
    
    /**
     * @param $params array expected keys: ['product_id'=>$productId,'cover_id'=>$coverId,'color_id'=>$colorId]
     * @return array|null|yii\db\ActiveRecord
     */
    public function getProductCover($params) {
        return ProductCover::find()
            ->with('file')
            ->where($params)
            ->asArray()
            ->one();
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function getProducts() {
        $products = Products::find()
            ->with('productLabels','file', 'productSales','productSales.activeSale')
            ->where(['active'=>Products::PROD_ACTIVE])
            ->orderBy('position')
            ->asArray()
            ->all();

        // Translate products name
        foreach ($products as $i => $product)
            $products[$i]['name'] = \Yii::t('backend_products_name', $products[$i]['name']);

        return $products;
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public function getLabels() {
        return Labels::find()
            ->with('labelSales')
         //   ->asArray()
            ->all();
    }
    
    public static function is_mobile() {
        if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
            $is_mobile = false;
        } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
                $is_mobile = true;
        } else {
            $is_mobile = false;
        }
        return $is_mobile;
    }
            
}