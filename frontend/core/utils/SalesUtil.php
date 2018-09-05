<?php
/**
 * Created by PhpStorm.
 * User: decadal
 * Date: 01.06.17
 * Time: 10:55
 */

namespace frontend\core\utils;


class SalesUtil extends BaseUtil
{

    function acceptSale($sale, $sum, $count) {
        if(!$sale['type']) {
            return  $sale['value'];
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
                $result['sale_val'] = $this->acceptSale($result, $total, $count);
                continue;
            }
            if ($result['sale_val'] < ($tmpSaleVal = $this->acceptSale($v, $total, $count))) {
                $result = $v;
                $result['sale_val'] = $tmpSaleVal;
            }
        }
        return $result;
    }

    function detectSale($cart) {
        $product = $cart['product'];
        $activeLabelSale = [];
        $activeProductSale = $this->getSaleByProduct($product);
        if(!empty($product['productLabels'])) {
            $label = $product['productLabels'][0]['label'];
            if(!empty($label['labelSales'])) {
                $activeLabelSale = $this->getSaleByLabel($label);
            }
        }
        $this->getSaleByCover($cart['cover']);
        return $this->compareSale(
            compact('activeProductSale', 'activeLabelSale','activeCoverSale'),
            $cart['total'],
            $cart['count']
        );
    }



    function getSaleByProduct($product) {
        $activeProductSale = [];
        if(!empty($product['productSales'])) {
            $activeProductSale = $product['productSales'][0]['activeSale'];
        }
        return $activeProductSale;
    }

    function getSaleByLabel($label) {
        $activeLabelSale = [];
        if(!empty($label['labelSales'])) {
            $activeLabelSale = $label['labelSales'][0]['activeSale'];
        }
        return $activeLabelSale;
    }

    function getSaleByCover($cover) {
        $activeCoverSale = [];
        if(!empty($cover['coverSales'])) {
            $activeCoverSale = $cover['coverSales'][0]['activeSale'];
        }
        return $activeCoverSale;
    }

}