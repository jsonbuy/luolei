<div class="outSide lbBox">
	<ul class="messageBox">
		<li class="lbBox">
			<span class="lineBlock titles">标题</span>
			<span class="lineBlock users">用户</span>
			<span class="lineBlock datas">发布时间</span>
		</li>
		<?php
			foreach ($model as $key => $value) {
		?>
		<li class="lbBox">
			<a class="lineBlock titles" dataId="<?php echo $value['id'] ?>" href="index.php?r=vipspark/messagecon&dataId=<?php echo $value['id'] ?>"><?php echo $value['title']  ?></a>
			<span class="lineBlock users"><?php echo $value['user']  ?></span>
			<span class="lineBlock datas"><?php echo $value['date']  ?></span>
			<a class="lineBlock delete" dataId="<?php echo $value['id'] ?>" href="javascript:void(0)">删除</a>
		</li>
		<?php
		}
		?>
	</ul>
	<div class="lineBlock posting">
		<p>我要发帖</p>
		<form method="post" action="index.php?r=vipspark/message" name="message">
			<input type="hidden" name="id" value="<?php ?>"/>
			<input class="inputTitle"  placeholder="请填写标题" type="text" name="title"><br>
			<textarea name="con" class="inputCon"></textarea><br>
			<input name="Submit" class="inputButt buttonmess" type="button" value="Submit" />
			<b class="red"></b>
		</form>
	</div>
</div>
