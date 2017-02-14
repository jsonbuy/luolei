
<div class="outSide lbBox">
	<div class="messageCon lineBlock">
		<a class="listMessage" href="index.php?r=vipspark/message">返回列表</a>
		<p class="messageConTitle"><?php echo $model['title'] ?></p>
		<input type="hidden" name="id" val />
		<ul class="lbBox">
			<li class="lineBlock messageConName">
				<p class="userHead louzhu"></p>
				<p class="userName"><?php echo $model['user']  ?></p>
			</li>
			<li class="lineBlock messageConTxt"><?php echo nl2br($model['message']) ?></li>
		</ul>
			<?php
				foreach ($models as $key => $value) {
			?>
			<ul class="lbBox huifuM">
				<li class="lineBlock messageConName">
					<p class="userHead"></p>
					<p class="userName"><?php echo $value['user'] ?></p>
				</li>
				<li class="lineBlock messageConTxt">
					<?php echo $value['message']  ?>
					<p class="date"><?php echo $value['date'] ?></p>
				</li>
			</ul>
			<?php
				}
			?>
			<form method="post">
				<textarea name="con" class="inputCon"></textarea><br>
				<input name="Submit" dataId="<?php echo $_GET['dataId'] ?>" class="inputButt inputButtCon" type="button" value="Submit" />
			</form>
	</div>
	<div class="messageRightCon lineBlock">
		<!-- <img src="img/weiXingGongZPT.jpg" /> -->
	</div>
</div>