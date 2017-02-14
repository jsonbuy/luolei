<?php

namespace app\controllers;

use Yii;
use yii\web\Request;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\OrderForm;
use app\ancdone\code\AncHelper;

class OrderController extends Controller
{
    
    /*==============================================================
      *函数名：  actionOrderAjax
      *作者：    json
      *日期：    2015-03-19
      *功能：  订单页面
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionOrderajax()
    {
        $model = new OrderForm();
        $qtyAjax = $model->orderQty();
        echo json_encode($qtyAjax);
    }
	/*==============================================================
	  *函数名：  actionOrder
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	订单页面
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
    public function actionOrder()
    {
    	$model = new OrderForm();
        $orderInf = $model->orderInf();
        $adressInf = $model->adressInf();
        $orderPayment = $model->orderPayment();
        return $this->render('order',
        [
        'orderInf'       => $orderInf,
        'adressInf'      => $adressInf,
        'orderPayment'   => $orderPayment,
        ]);
    }
    /*==============================================================
      *函数名：  actionOrderlist
      *作者：    json
      *日期：    2015-03-19
      *功能：  订单页面
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionOrderlist()
    {
        $this->layout = FALSE;//不要头底
        $model = new OrderForm();
        $orderInf = $model->orderInf();
        return $this->render('orderList',
        [
        'orderInf'       => $orderInf,
        ]);
    }
    /*==============================================================
      *函数名：  actionOrderpay
      *作者：    json
      *日期：    2015-03-19
      *功能：  订单支付页面
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionOrderpay()
    {
        $model = new OrderForm();
        $postInfo = \Yii::$app->request->get();
        $upfile = array();
        $upfile['order']   = $postInfo['orderNumber'];
        $orderInf = $model->orderPaymentclip($upfile);
        return $this->render('pay',
        [
        'orderInf'       => $orderInf,
        ]);
    }
    /*==============================================================
      *函数名：  actionAddadress
      *作者：    json
      *日期：    2015-03-19
      *功能：  订单页面
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionAddadress()
    {
        $model = new OrderForm();
        $postInfo = \Yii::$app->request->get();
        $upfile = array();
        $upfile['firstName']   = $postInfo['firstName'];
        $upfile['lastName']    = $postInfo['lastName'];
        $upfile['country']     = $postInfo['country'];
        $upfile['address']     = $postInfo['address'];
        $upfile['city']        = $postInfo['city'];
        $upfile['phoneNumber'] = $postInfo['phoneNumber'];
        $upfile['checkDefault']= $postInfo['checkDefault'];
        $model->orderAddress($upfile);
    }
    /*==============================================================
      *函数名：  actionDeletdress
      *作者：    json
      *日期：    2015-03-19
      *功能：  删除地址
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionDeletdress()
    {
        $model = new OrderForm();
        $postInfo = \Yii::$app->request->get();
        $upfile = array();
        $upfile['id']   = $postInfo['id'];
        $model->orderDeletdress($upfile);
    }
    /*==============================================================
      *函数名：  actionUpdatadress
      *作者：    json
      *日期：    2015-03-19
      *功能：  修改默认地址
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionUpdatadress()
    {
        $model = new OrderForm();
        $postInfo = \Yii::$app->request->get();
        $upfile = array();
        $upfile['id']   = $postInfo['id'];
        $model->orderUpdatadress($upfile);
    }
    /*==============================================================
      *函数名：  actionCreateorder
      *作者：    json
      *日期：    2017-02-07
      *功能：  生成订单
      *参数：    
      *返回值：  
      *修改记录：
    ===============================================================*/
    public function actionCreateorder()
    {
        $model = new OrderForm();
        $postInfo = \Yii::$app->request->get();
        $rand = new AncHelper();
        $orderNumber = $rand::randNumber(10);
        $date = strtotime(date('Y-m-d H:i:s',time()));
        $data = array();
        $data['id']         = $postInfo['id'];
        $data['user']       = $postInfo['user'];
        $data['address']    = $postInfo['address'];
        $data['priceTotal'] = $postInfo['priceTotal'];
        $data['payment']    = $postInfo['payment'];
        $data['ordernumber']= $orderNumber;
        $data['date']       = $date;
        $response = $model->orderCreate($data);
        if($response == true){
            $response = array('ret'=>1,'orderNumber'=>$data['ordernumber']);
            return json_encode($response);
            exit;
        }else{
            $response = array('ret'=>0);
            return json_encode($response);
            exit;
        }
    }

}
?>