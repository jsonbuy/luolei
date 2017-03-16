<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductlistForm;
use app\models\productList;

use app\models\ancadmin;
use app\models\Ancadmin_product;
use app\models\Ancadmin_productimgarr;

class ProductlistController extends Controller
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
    public function actionProductlist()
    {
    	$model      = new ProductlistForm();
		$product    = $model->ProductList();
        return $this->render('productList',
        [
        	'product'    => $product,
        ]);
    }

}
?>