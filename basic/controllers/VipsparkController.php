<?php

namespace app\controllers;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use app\models\SparkForm;
use app\ancdone\code\AncCaptcha;
use app\ancdone\code\AncHelper;
use app\ancdone\code\AncSendemail;

class VipsparkController extends Controller
{

	/*==============================================================
	  *函数名：  actionSin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	对 CSRF攻击做处理，会对 post提交的数据做 token验证 、关闭之后是不安全的；
	===============================================================*/
	public $enableCsrfValidation = false;
	/*==============================================================
	  *函数名：  actionSin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	登陆界面；
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
    public function actionSin()
    {
        return $this->render('vipspark');
    }
	/*==============================================================
	  *函数名：  actionLogin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	登陆，用户名密码是否正确；
	  *参数：    
	  *返回值：  0,1
	  *修改记录：
	===============================================================*/
     public function actionLogin()
    {
		$model = new SparkForm();
    	$model = $model->LoginIn();
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	/*==============================================================
	  *函数名：  actionLogin
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	登陆，用户名密码是否正确；
	  *参数：    
	  *返回值：  0,1
	  *修改记录：
	===============================================================*/
     public function actionRegister()
    {
        return $this->render('register');
    }
     public function actionInsterreg()
    {
		$postInfo = \Yii::$app->request->post();
		
		$vcode = new AncCaptcha();
		if($vcode->check($postInfo['code'])){
			$registerUser = htmlspecialchars($postInfo['email']);
			$registerPass = MD5($postInfo['pass']);
			$registerPassA = MD5($postInfo['passworda']);
			$emailMd5 = MD5($postInfo['email']);
			$code = $postInfo['code'];
			$date = date('Y/m/d');
			
			$reg = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/";
			if(!isset($registerUser) && $registerUser == ''){
				echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'This field is required!'));
				exit;
			}
			if(isset($registerUser)){
				if ( !preg_match( $reg, $registerUser ) ){
					echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'You\'ve entered the wrong email format!'));
					exit;
				}
			}
			
			if((!isset($registerPass) && $registerPass == '') && (!isset($registerPassA) && $registerPassA == '')){
				echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'This field is required!'));
				exit;
			}
			
			if($registerPass !== $registerPassA){
				echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'Enter the same password as above!'));
				exit;
			}
			
			if(strlen($registerPass)<6){
				echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'Please enter at least 6 characters!'));
				exit;
			}
				
			$register = array();
			$register['username'] = $registerUser;
			$register['password'] = $registerPass;
			$register['verifyMessage'] = $emailMd5;
			$register['zc_date'] = $date;
			
	    	$mode = new SparkForm();
			$model = $mode->Register($register);
		}else{
			echo AncHelper::jsonEncode(array('status'=>0,'errorMessage'=>'Verification code error'));
			exit;
		}
    }
	/**
     * @desc 验证码
     */
    public function actionCode(){
    	session_start();
	    $vcode = new AncCaptcha();
	    $vcode->entry();  
    }
	/*==============================================================
	  *函数名：  actionSendemail
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	发送邮件  忘记密码；
	  *参数：    
	  *返回值：  0,1
	  *修改记录：
	===============================================================*/
     public function actionSendpage()
    {
        return $this->render('sendEmail');
    }
     public function actionSendcode()
    {
        return $this->render('emailCode');
    }
	public function actionSendemail(){
		$postInfo = \Yii::$app->request->post();
		
    	$session = \yii::$app->session;
    	$num = "";
		for($i=0;$i<4;$i++){
			$num .= rand(0,9);
		}
	   // $sEmail = new AncSendemail();
	    //$sEmail -> sendCode($num);
		
		$mail = Yii::$app->mailer->compose()
	    ->setFrom('ll1106@163.com')
	    ->setTo($postInfo['email'])
	    ->setSubject('ANCdone forgot password')
	    ->setTextBody('Plain text content')
	    ->setHtmlBody('<b>您本次的验证码为 </b>'.$num.'清在30分钟之内完成验证')
	    ->send();
		if($mail){
			header("Location:index.php?r=vipspark/sendcode");
			exit;
		}else{
			echo "Send mail failed!";
		}
		session_start();
		$session['CODE'] = $num;
		$session['email']= $postInfo['email'];
		
		// $model = new SparkForm();
    	// $model = $model->SendEmail();
    	
		
	}
	/*==============================================================
	  *函数名：  actionMessage
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	获取评论列表
	  *参数：    
	  *返回值：  Type（Array)
	  *修改记录：
	===============================================================*/
    public function actionMessage()
    {
		$mode = new SparkForm();
		$model = $mode->SelectDb();
		//$insert = $mode->InsertMessage();
        return $this->render('message', [
            'model' => $model,
        ]);
    }

	/*==============================================================
	  *函数名：  actionInsert
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	ajax异步返回数据 插入数据库
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
	public function actionInsert()
	{
		$session = \yii::$app->session;
		$postInfo = \Yii::$app->request->post();
		
		$userTxt = $session['username'];
		$titleTxt = $postInfo['title'];
		$messageTxt = $postInfo['con'];
		$date = date("Y-m-d H:i:s", time() + 8 * 3600);
		
		if($titleTxt == '' || $messageTxt == ''){
			$respons = array('status' => 2 , 'message' => 'empty!!');
			echo json_encode($respons);
			exit;
		}
		$param = array();
		$param['username'] = $userTxt;
		$param['title'] = $titleTxt;
		$param['con'] = $messageTxt;
		$param['date'] = $date;
    	$mode = new SparkForm();
		$model = $mode->Insert($param);
		
		if($model){
			$respons = array('status' => 1,'message'=>'insert successful');
			echo json_encode($respons);
			exit;
		}else{
			$respons = array('status' => 0,'errormessage' => 'insert failure');
			echo json_encode($respons);
			exit;
		}
	}
	/*==============================================================
	  *函数名：  actionInsert
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	ajax异步返回数据 插入数据库
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
	public function actionInsertcon()
	{
		$session = \yii::$app->session;
		$postInfo = \Yii::$app->request->post();
		
		$userTxt = $session['username'];
		$uid = $postInfo['dataId'];
		$messageTxt = $postInfo['con'];
		$date = date("Y-m-d H:i:s", time() + 8 * 3600);
		
		if($messageTxt == ''){
			$respons = array('status' => 2 , 'message' => 'empty!!');
			echo json_encode($respons);
			exit;
		}
		$param = array();
		$param['username'] = $userTxt;
		$param['uid'] = $uid;
		$param['con'] = $messageTxt;
		$param['date'] = $date;
    	$mode = new SparkForm();
		$model = $mode->Insertcon($param);
		if($model){
			$respons = array('status' => 1,'message'=>'insert successful');
			echo json_encode($respons);
			exit;
		}else{
			$respons = array('status' => 0,'errormessage' => 'insert failure');
			echo json_encode($respons);
			exit;
		}
	}
	/*==============================================================
	  *函数名：  actionDelete
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	ajax异步返回数据 插入数据库
	  *参数：    
	  *返回值：  
	  *修改记录：
	===============================================================*/
	public function actionDelete()
	{
		$postInfo = \Yii::$app->request->post();
		$dataId = $postInfo['dataId'];

		$param = array();
		$param['dataId'] = $dataId;
		
    	$mode = new SparkForm();
		$model = $mode->Delete($param);
		
		if($model){
			$respons = array('status' => 1,'message'=>'insert successful');
			echo json_encode($respons);
			exit;
		}
	}
	/*==============================================================
	  *函数名：  actionMessagecon
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	详情展示，相关评论
	  *参数：    
	  *返回值：  Type（Array)
	  *修改记录：
	===============================================================*/
	public function actionMessagecon()
	{
		$mode = new SparkForm();
		$model = $mode->MessageCon();
		$models = $mode->MessageEach();
		return $this -> render('messageCon',array(
			'model' => $model,
			'models' => $models,
		));
	}
	/*==============================================================
	  *函数名：  actionMessagecon
	  *作者：    json
	  *日期：    2015-03-19
	  *功能：	详情展示，相关评论
	  *参数：    
	  *返回值：  Type（Array)
	  *修改记录：
	===============================================================*/
	public function actionDelmess()
	{
		$mode = new SparkForm();
		$model = $mode->MessageCon();
		$models = $mode->MessageEach();
		return $this -> render('messageCon',array(
			'model' => $model,
			'models' => $models,
		));
	}
	
}





















