<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin([
        'id' => 'register-form',
    ]); ?>
    
<div class="registerWarp">
	<div class="contentInside">
		<div class="signRegiser">
			<p class="logoTitle">Create your account</p>
		      <div class="controls">
		      	<i class="icon-email"> </i>
		        <input type="text" id="register_email" placeholder="Enter your email" autocomplete="off">
		        <span class="help-block"></span>
		      </div>
		      <div class="controls">
		      	<i class="icon-lock"> </i>
		        <input type="password" id="register_password" placeholder="Enter your password">
		        <span class="help-block"></span>
		      </div>
		      <ul class="lbUl passLevel">
		      	<li class="passLow">LOW</li>
		      	<li class="passMedium">MEDIUM</li>
		      	<li class="passHigh">HIGH</li>
		      </ul>
		      <p class="passLen">This should be at least 6 characters long and will be case sensitive.</p>
		      <div class="controls">
		      	<i class="icon-lock"></i>
		        <input type="password" id="register_passwordAgain" placeholder="Confirm your password">
		        <span class="help-block"> </span>
		      </div>
		      <div class="controls">
		        <input class="codeInput" type="text" placeholder="code" autocomplete="off" name="code" maxlength="4">
		        <div class="code lineBlock"><img src="index.php?r=vipspark/code" alt="Click the refresh verification code" onclick="javascript:this.src='index.php?r=vipspark/code&tm='+Math.random();" /></div>
		        <span class="help-block"></span>
		      </div>
		      <!-- <label class="selectLabel iAgree">
		      	<i class="multi-select"> </i>I agree to the chicuu Terms & Conditions
		        <span class="help-block"></span>
		      </label>
		      <label class="selectLabel">
		      	<i class="multi-select multiAci"> </i>Yes, Sign up our newsletter, get a $50 coupon in your first email!
		        <span class="help-block"></span>
		      </label> -->
		      <input type="button" value="CREATE ACCOUNT" id="createAccount" class="btn btn-primary">
		      <span id="error" class="help-inline"></span>
		      <div class="haveAccount">
			      <p class="lineBlock">Already have an account? </p>
			      <a href="index.php?r=vipspark/sin" class="lineBlock">Sign in</a>
		      </div>
		</div>
	</div>
</div>

<?php ActiveForm::end(); ?>