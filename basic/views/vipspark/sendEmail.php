<div class="LoginOtherWarp">
	<div class="contentInside">
		<div class="signRegiser">
			<form method="post"  action="index.php?r=vipspark/sendemail">
				<div class="controls">
			      	<i class="icon-email"> </i>
			        <input id="sign_email" name="email" type="text" placeholder="Enter your email" autocomplete="off">
			        <span class="help-block"></span>
			      </div>
					<?php
						// include_once("../configs/conn.php");
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
					?>
				<input class="btn btn-primary" id="register" name="submit" type="submit" value="Send E-mail" />
			</form>
		</div>
	</div>
</div>
