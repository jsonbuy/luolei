<?php
use app\ancdone\code\AncHelper;
?>
<ul class="lbUl porductList">
	<?php
		foreach ($product as $key => $value) {
			$productimg    = explode(",",$value["imgarr"]);
	?>
	<li>
		<a href="index.php?r=product/product&id=<?php echo $value['id']?>"><img width="230" height="230" src="<?php echo AncHelper::settingPaths().'productImg/'.$productimg[0]?>" /></a>
		<a href="index.php?r=product/product&id=<?php echo $value['id']?>" class="proListTitle"><?php echo $value['title']?></a>
		<div class="lbBox proListPrice">
			<p class="lineBlock price">US$ <span><?php echo $value['price']?></span></p>
			<p class="lineBlock qty">QTY: <span><?php echo $value['qty']?></span></p>
		</div>
		<p class="freeShipping">Free shipping</p>
	</li>
	<?php
		}
	?>
</ul>