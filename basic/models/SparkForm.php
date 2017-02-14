<?php
	namespace app\models;
	use Yii;
	use yii\base\Model;
	use yii\web\session;
	use Yii\db\ActiveRecord;
	
	class SparkForm extends Model
	{
		/*==============================================================
		  *函数名：  LoginIn
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	用户点击登陆，成功设置session：username；
		  *参数：    
		  *返回值：0，1
		  *修改记录：
		===============================================================*/
		public function LoginIn()
		{
			$session = \yii::$app->session;
			
			$username = htmlspecialchars($_POST['email']);
			$pass = MD5($_POST['pw']);
			$command = (new \yii\db\Query())
			->select(['username','password'])
			->from('user')
			->where(['username'=>$username,'password'=>$pass])
			->one();
			
			if($command){
				$session->set('username',$username);
				$response = array('status'=>1,'message'=>'login sucess');
				echo json_encode($response);
				exit;
			}else{
				$respons = array('status' => 0,'message'=>'login error');
				echo json_encode($respons);
				exit;
			}
		}
		/*==============================================================
		  *函数名：  Register
		  *作者：    json
		  *日期：    2015-04-07
		  *功能：	用户点击注册
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function Register($register)
		{
			
			$connection = \Yii::$app->db;
			
			$row =(new \yii\db\Query())
			->select(['username'])
			->from('user')
			->where(['username'=>$register['username']])
			->one();
			if($row){
				$response = array('status' => 2,'message'=>'账户已存在');
				echo json_encode($response);
				exit;
			}else{
				$insert = $connection->createCommand()
				->insert('user',array(
					'username' => $register['username'],
					'password' => $register['password'],
					'zc_date' => $register['zc_date'],
					'verifyMessage' => $register['verifyMessage'],
					'verify' => '0',
					'vip' => '5',
				))
				->execute();
				$response = array('status' => 1,'message'=>'ok');
				echo json_encode($response);
				return $insert;
				exit;
			}
		}
		/*==============================================================
		  *函数名：  SendEmail
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	忘记密码 发送邮件功能
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function SendEmail()
		{
			// include_once("mail/changePassword_email.php");
			// if(isset($_POST['submit'])){
				// $email = $_POST['email'];
				// $sql = "SELECT `username` FROM `user` WHERE username = '".$email."'";
				// $query = mysqli_query($con,$sql);
				// if(mysqli_fetch_row($query)){
					// $num = "";
					// for($i=0;$i<4;$i++){
						// $num .= rand(0,9);
					// }
					// session_start();
					// $_SESSION['CODE'] = $num;
					// $_SESSION['email'] = $email;
					// sendCode($num);
					// echo "<script>window.location = 'sendCode.php'</script>";
				// }else{
					// echo "用户名不正确！";
				// }
			// }
		}
		
		/*==============================================================
		  *函数名：  indexBanner
		  *作者：    json
		  *日期：    2015-03-19
		  *功能：	首页banner取数据
		  *参数：    
		  *返回值：
		  *修改记录：
		===============================================================*/
		public function indexBanner()
		{
		 	$rows = (new \yii\db\Query())
		    ->select(['title', 'imgpath', 'imgurl'])
		    ->from('ancadmin_banner')
			->orderBy(['id'=>SORT_ASC])
		    ->all();
			return $rows;
		}
		
		
		/*==============================================================
          *函数名：  SelectDb
          *作者：    json
          *日期：    2015-03-19
          *功能：  首页banner取数据
          *参数：    
          *返回值：
          *修改记录：
        ===============================================================*/
        public function SelectDb()
        {
            $rows = (new \yii\db\Query())
            ->select(['id', 'user', 'date', 'title'])
            ->from('leavemessage')
            ->orderBy(['id'=>SORT_ASC])
            ->all();
            return $rows;
        }
		
		
		
	}
?>






















