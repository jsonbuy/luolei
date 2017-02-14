<?php
use app\ancdone\code\AncHelper;
?>
<div class="lbBox showCaseWarp">
	<div class="lineBlock">
		<!--大图展示-->
    	<div class="productBigPic_box">
    		<ul class="hoverBig">
            	<li class="zoom-small-image">
            		<a href='<?php echo AncHelper::settingPaths()?>productImg/<?php echo $productImg[0]?>' class = 'cloud-zoom' id='zoom1' rel="adjustX:10, adjustY:-4"><img src="<?php echo AncHelper::settingPaths()?>productImg/<?php echo $productImg[0]?>" /></a>
            	</li>
            </ul>
        </div>
        <!--小图片点击切换-->
        <div class="showCaseSmall_box moveWarp lbBox" id="showCaseSmallPic">
            <a href="javascript:;" class="showCaseL moveLeftClick lineBlock"><i class="icon-smallL"> </i></a>
            <div class="productSmallPic moveHidden lineBlock">
                <ul class="productSmallmove lbBox moveBox">
                	<?php
                		foreach ($productImg as $key => $value) {
					?>
					<li class="lineBlock moveList">
                    	<a href='<?php echo AncHelper::settingPaths()?>productImg/<?php echo $value?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo AncHelper::settingPaths()?>productImg/<?php echo $value?>' ">
                    	    <img class="zoom-tiny-image" src="<?php echo AncHelper::settingPaths()?>productImg/<?php echo $value?>" />
                    	</a>
                    </li>
					<?php
						}
                	?>
                </ul>
            </div>
            <a href="javascript:;" class="showCaseR moveRightClick lineBlock"><i class="icon-smallR"> </i></a>
        </div>
	</div>
	<div class="lineBlock proInf">
		<h1><?php echo $product['title']?></h1>
		<span class="sku"> ( SKU: <?php echo $product['sku']?> )</span>
		<div class="share">
			<span>Share:</span>
			<div class="lineBlock">
            		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-532965a902fc0807" async="async"></script>
					<div class="addthis_sharing_toolbox"> </div>
            	</div>
          	</div>
		<div class="infPrice">
			Price: 
			<span class="lineBlock" id="currency">US$</span> 
			<span class="lineBlock" id="price"><?php echo $product['price']?></span>
		</div>
		<div class="infPrice">
			Qty: 
			<span class="lineBlock" id="price"><?php echo $product['qty']?></span>
		</div>
		<div class="infWarehouse">
			<p class="lineBlock">Shipping From:</p>
			<p class="lineBlock">USA Warehouse</p>
		</div>
		<p class="infFreeShip">FREE Shipping</p>
		<p>In Stock - Usually will be shipped in 24 hours</p>
		<div class="qty">
			<p class="lineBlock">QTY:</p>
			<div id="number" class="lineBlock lbBox">
				<a class="lineBlock prev" href="javascript:;">--</a>
				<input type="text" value="1" class="lineBlock" onpaste="return false;" id="quantity">
				<a class="lineBlock next" href="javascript:;">+</a>
			</div>
		</div>
		<div class="addCart">
		    <input type="hidden" id="uid" value="<?php echo $product['id']?>">
			<a class="btn btn-orange buyNow" href="javascript:void(0)"><i class="icon-prCart"> </i>Buy Now</a>
		</div>
	</div>
	<div class="proInfWarp">
		<?php echo nl2br($productinf['proinf'])?>
	</div>
</div>