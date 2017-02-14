<?php

namespace app\controllers;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\AncadminForm;
use app\ancdone\code\AncHelper;


class AncadminController extends Controller
{
	/*==============================================================
	  *函数名：  actionSin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	对 CSRF攻击做处理，会对 post提交的数据做 token验证 、关闭之后是不安全的；
	===============================================================*/
	public $enableCsrfValidation = false;
	/*==============================================================
	  *函数名：  actionAdmin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	后台登陆；
	  *参数：    
	  *返回值：  0,1
	  *修改记录：
	===============================================================*/
	public function actionAdmin()
    {
		// $model = new AncadminForm();
    	// $model = $model->LoginIn();
        return $this->render('login');
    }
	/*==============================================================
	  *函数名：  actionAdmin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	后台登陆；
	  *参数：    
	  *返回值：  0,1
	  *修改记录：
	===============================================================*/
	public function actionLogin()
    {
		$model = new AncadminForm();
    	$model = $model->LoginIn();
        return $this->render('login');
    }
	/*==============================================================
	  *函数名：  actionIndex
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionIndex()
    {
    	//$this->layout = false;//不调用布局
    	$postInfo = \Yii::$app->request->post();
    	$page = $_GET['page'];
    	$model = new AncadminForm();
    	if($page == 'index'){
			/*====================文件上传========================*/
		    if (Yii::$app->request->isPost) {
		        $image = $model->file = UploadedFile::getInstance($model, 'file');
				$ext = $image->getExtension();
	            $randName = time() . rand(1000, 9999) . "." . $ext; 
	            //随机文件名//$path = abs(crc32($randName) % 500);  //多目录存储
		        if ($model->file && $model->validate()) {
		        	$model->file->saveAs('banner/' . $randName);    
		        	//$model->file->saveAs('banner/' . $model->file->baseName . '.' . $model->file->extension);
		        }
		    }
			if(isset($_POST['submit'])){
				$upfile = array();
				$upfile['title']   = $postInfo['title'];
				$upfile['imgurl']  = $postInfo['imgurl'];
				$upfile['imgpath'] = $randName;
				$model->UpFile($upfile);
			}
			$editbanner = $model->EdiShowBanner();
    		$indexPage = $this->renderPartial('indexBanner', ['model' => $model,'editbanner' => $editbanner]);
    	}elseif($page == 'product'){
    		$indexPage = $this->renderPartial('product', ['model' => $model]);
    	}elseif($page == 'productsearch'){
    		$productProinf ='';
    		if(isset($_GET['sku'])){
	    		$proinf = array();
				$proinf['sku'] = $_GET['sku'];
				$productProinf = $model->searchSku($proinf);
			}
    		$indexPage = $this->renderPartial('productsearch', ['productProinf' => $productProinf]); 
    	}
    	
		$data = array();
		$data['indexPage'] = $indexPage;
		
        return $this->render('index',$data);
    }
	/*==============================================================
	  *函数名：  actionUpdatebanner
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	编辑bannne标题 和链接地址
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionUpdatebanner(){
		$postInfo = \Yii::$app->request->post();
		$model = new AncadminForm();
		$update = array();
		$update['id']     = $postInfo['id'];
		$update['title']  = $postInfo['title'];
		$update['imgurl'] = $postInfo['imgurl'];
		$editbanner = $model->UpdateBanner($update);
	}
	/*==============================================================
	  *函数名：  actionDeletebanner
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	删除 banner
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionDeletebanner(){
		$postInfo = \Yii::$app->request->post();
		$model  = new AncadminForm();
		$delete = array();
		$delete['id'] = $postInfo['id'];
		$delete['banner'] = $postInfo['banner'];
		$editbanner = $model->DeleteBanner($delete);
	}
	/*==============================================================
	  *函数名：  actionUpproductimg
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	多图上传
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionUpproductimg(){
		$typeArr = array("jpg", "png", "gif");//允许上传文件格式
		$path = AncHelper::settingPath()."/web/productImg/";//上传路径
		
		if (isset($_POST)) {
		    $name = $_FILES['file']['name'];
		    $size = $_FILES['file']['size'];
		    $name_tmp = $_FILES['file']['tmp_name'];
		    if (empty($name)) {
		        echo json_encode(array("error"=>"您还未选择图片"));
		        exit;
		    }
		    $type = strtolower(substr(strrchr($name, '.'), 1)); //获取文件类型
		    
		    if (!in_array($type, $typeArr)) {
		        echo json_encode(array("error"=>"清上传jpg,png或gif类型的图片！"));
		        exit;
		    }
		    if ($size > (500 * 1024)) {
		        echo json_encode(array("error"=>"图片大小已超过500KB！"));
		        exit;
		    }
		    $pic_name = time() . rand(10000, 99999) . "." . $type;//图片名称
		    $pic_url = $path . $pic_name;//上传后图片路径+名称
		    if (move_uploaded_file($name_tmp, $pic_url)) { //临时文件转移到目标文件夹
		        echo json_encode(array("error"=>"0","pic"=>$pic_url,"name"=>$pic_name));
		    } else {
		        echo json_encode(array("error"=>"上传有误，清检查服务器配置！"));
		    }
		}
	}
	/*==============================================================
	  *函数名：  actionDeleteproimg
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	删除 正在上传的产品图片
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionDeleteproimg(){
		$postInfo = \Yii::$app->request->post();
		$deleteimg = $postInfo['urls'];
		//$proimg = basename($deleteimg);
		if(is_file($deleteimg)){
			$unlinks = unlink($deleteimg);
			if(isset($_GET['sku'])){
				// $model  = new AncadminForm();
				// $editbanner = $model->UpdateProimg($postInfo);
			}
		}else{
			$unlinks = false;
		}
		
		
		if(isset($_GET['sku'])){
			$model  = new AncadminForm();
			$editbanner = $model->UpdateProimg($postInfo);
		}
		if($unlinks){
			$response = array('status'=>1,'message'=>'delete sucess');
			echo json_encode($response);
			exit;
		}else{
			$respons = array('status' => 0,'message'=>'delete error');
			echo json_encode($respons);
			exit;
		}
	}
	/*==============================================================
	  *函数名：  actionDeleteproimg
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	删除 正在上传的产品图片
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionProinf(){
		$postInfo = \Yii::$app->request->post();
		$model = new AncadminForm();
		
		$proinf = array();
		$proinf['title']        = $postInfo['title'];
		$proinf['sku']          = $postInfo['sku'];
		$proinf['price']        = $postInfo['price'];
        $proinf['disprice']     = $postInfo['disprice'];
		$proinf['freeShipping'] = '0';
		$proinf['qty']          = $postInfo['qty'];
		$proinf['productInf']   = $postInfo['productInf'];
		$proinf['imgArray']     = $postInfo['imgArray'];
		
		$productProinf = $model->ProductProinf($proinf);
	}
	/*==============================================================
	  *函数名：  actionSearchsku
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	搜索sku 后台
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionSearchsku(){
		$postInfo = \Yii::$app->request->post();
		$model = new AncadminForm();
		
		$proinf = array();
		$proinf['sku']          = $postInfo['sku'];
		$productProinf = $model->searchSku($proinf);
	}
	/*==============================================================
	  *函数名：  actionSearchsku
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	搜索sku 后台
	  *参数：    
	  *返回值：
	  *修改记录：
	===============================================================*/
	public function actionUpdateproduct(){
		$postInfo = \Yii::$app->request->post();
		$model = new AncadminForm();
		
		$proinf = array();
		$proinf['id']          = $postInfo['id'];
		$proinf['title']        = $postInfo['title'];
		$proinf['sku']          = $postInfo['sku'];
		$proinf['price']        = $postInfo['price'];
        $proinf['disprice']     = $postInfo['disprice'];
		$proinf['qty']          = $postInfo['qty'];
		$proinf['productInf']   = $postInfo['productInf'];
		$proinf['imgArray']     = $postInfo['imgArray'];
		$productProinf = $model->updateProduct($proinf);
	}
	
	
	
}

















