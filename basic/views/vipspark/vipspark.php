<!-- <div class="outSide lbBox">
	<div class="title lineBlock">
		<ul class="lbBox loginNav">
			<li class="lineBlock acitive">登 录</li>
			<li class="lineBlock"><a href="register.html">注 册</a></li>
		</ul>
		<form method="post" name="loginForm" onsubmit="return InputCheck(this)">
			<div class="inputBox">
				<span>用户名:</span><input class="inputTitle" name="user" type="text" placeholder="email@email.com" >
				<p class="emails"></p>
			</div>
			<div class="inputBox">
				<span>密码:</span><input class="inputTitle" name="pass" type="password" placeholder="输入密码">
				<p class="hiddens"></p>
			</div>
			<input class="inputButt" id="login" name="submit" type="button" value="登 录" />
			<a class="forgotPass" href="sendEmail.php">忘记密码？</a>
		</form>
	</div>
</div> -->

<div class="LoginWarp">
	<div class="contentInside">
		<div class="signRegiser">
			<p class="logoTitle">Sign In to ancdone.com</p>
		      <div class="controls">
		      	<i class="icon-email"> </i>
		        <input id="sign_email" name="user" type="text" placeholder="Enter your email" autocomplete="off">
		        <span class="help-block"></span>
		      </div>
		      <div class="controls">
		      	<i class="icon-lock"> </i>
		        <input id="sign_password" name="pass" type="password" placeholder="Enter your password">
		        <span class="help-block"></span>
		      </div>
		      <input type="button" value="LOGIN" class="btn btn-primary" id="login">
		      <a class="forgetPs" href="index.php?r=vipspark/sendpage">Forgot your password?</a>
		      <div class="haveAccount">
			      <p class="lineBlock">Don't have an account? </p>
			      <a href="index.php?r=vipspark/register" class="lineBlock">Create one</a>
		      </div>
		</div>
	</div>
</div>