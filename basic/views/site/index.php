<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="bannerIn">
	<ul class="bannerImg">
		<?php
			foreach ($imgBanner as $key => $value) {
		?>
		<li><a href="<?php echo $value['imgurl'] ?>"><img title="<?php echo $value['title']?>" src="banner/<?php echo $value['imgpath']?>" /></a></li>
		<?php
			}
		?>
	</ul>
</div>

<ul class="indexWarp lbUl">
	<li>
		<a href="javascript:void(0);">
			<p>NEW</p>
			<span>New Arrivals</span>
		</a>
	</li>
	<li>
		<a href="javascript:void(0);">
			<p>DEALS</p>
			<span>Product Deals</span>
		</a>
	</li>
	<li>
		<a href="javascript:void(0);">
			<p>AMAZON</p>
			<span>Welcome AMAZON</span>
		</a>
	</li>
</ul>


