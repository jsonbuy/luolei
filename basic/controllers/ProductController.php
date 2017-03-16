<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductForm;
use app\models\productList;

use app\models\ancadmin;
use app\models\Ancadmin_product;
use app\models\Ancadmin_productimgarr;

class ProductController extends Controller
{
	/*==============================================================
	  *函数名：  actionProduct
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	产品页面展示
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
    public function actionProduct()
    {
    	$model = new ProductForm();
		$product = $model->productInf();
		$productinf = $model->productDetails();
		$productImg = $model->productImgArr();
        $productSpuData = $model->productDataspu();
        $productDataInf = $model->productDataInf();
        $productInfo = array();
        $productData = array();
        foreach ($productSpuData as $key => $value) {
            $productInfo[$key] = $value;
            $productInfo[$key]['data'] = array($value['product_class']=>$value['product_data']);
            unset($productInfo[$key]['product_class']);
            unset($productInfo[$key]['product_data']);
            if($key > 0 && in_array($productSpuData[$key]['sku'], $productInfo[$key-1])){
                $productInfo[$key-1]['data'] = array_merge($productInfo[$key-1]['data'],$productInfo[$key]['data']);
                array_push($productData,$productInfo[$key-1]);
            }
        }
		$productImg = explode(",",$productImg['imgarr']);
        return $this->render('product',
        [
        	'product'         => $product ,
        	'productinf'      => $productinf,
        	'productImg'      => $productImg,
        	'productSpuData'  => $productData,
        	'productDataInf'  => $productDataInf
        ]);
    }

}
?>