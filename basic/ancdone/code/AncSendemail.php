<?php
namespace app\ancdone\code;
use Yii;
//use app\ancdone\code\phpmailer\PHPMailer;
class AncSendemail{
	public static function sendCode($code){
		error_reporting(E_STRICT);
		
		date_default_timezone_set('America/Toronto');
		
		require_once('phpmailer/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		$mail             = new PHPMailer();
		
		$body             = file_get_contents('contents.html');
		$body             = preg_replace('/[\]/','',$body);
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "smtp.163.com"; 	   // SMTP server
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		                                           // 1 = errors and messages
		                                           // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "smtp.163.com";		   // sets the SMTP server
		$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "ll1106@163.com"; 	   // SMTP account username
		$mail->Password   = "kuaile221520";        // SMTP account password
		
		$mail->SetFrom('ll1106@163.com', '斯帕克影视');
		
		$mail->AddReplyTo("ll1106@163.com","斯帕克影视");
		
		$mail->Subject    = "斯帕克影视，密码修改验证码发送";
		
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML('<b>亲爱的用户：</b>
		 <p>您好！感谢您使用百度服务，您正在进行邮箱验证，本次请求的验证码为：</p>
		'.$code.'(为了保障您帐号的安全性，请在1小时内完成验证。)');   //发送内容
		
		$address = $_POST['email'];//获取注册的邮件  发送邮件给他
		$mail->AddAddress($address, "John Doe"); //收件人名称
		
		// $mail->AddAttachment("images/phpmailer.gif");      // attachment
		// $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		$mail->CharSet = "utf-8"; //设置编码 
		
		if(!$mail->Send()) {
		  echo "发送失败";
		} else {
		  echo "发送成功";
		}
	}
}
?>

