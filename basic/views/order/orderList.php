
        <?php
            if(!isset($_COOKIE["plist"])){
        ?>
        <ul class="lbUl orderUl orderCon">
            <li class="orderLi1">
                none
            </li>
        </ul>
        <?php
            }else{
            $plistCookie = json_decode($_COOKIE["plist"],true);
            foreach ($orderInf as $key => $value) {
                $productimg    = explode(",",$value["imgarr"]);
                foreach ($plistCookie as $keys => $values) {//循环cookie
                    if($value['id'] == $values['uid']){
        ?>
    <ul class="lbUl orderUl orderCon">
        <li class="orderLi0 checkInput">
            <?php
                if($values['check'] == true){
            ?>
            <input type="checkbox" checked="checked" class="selectProduct" data-uid="<?php echo $value['id'] ?>" />
            <?php
                }else{
            ?>
            <input type="checkbox" data-uid="<?php echo $value['id'] ?>" />
            <?php
                }
            ?>
        </li>
        <li class="orderLi1">
            <img src="productImg/<?php echo $productimg[0] ?>" />
        </li>
        <li class="orderLi2">
            <p><?php echo $value['title'] ?> </p>
            <p>
                <span>Item#: 
                    <i><?php echo $value['sku'] ?></i>
                </span>
                <!-- <span>Color: 
                    <i>black</i>
                </span> -->
            </p>
        </li>
        <li class="orderLi3">
            <p>
                <span>US$</span>
                <span><?php echo $value['price'] ?></span>
                <input class="priceTos" type="hidden" value="<?php echo $value['price']; ?>">
            </p>
            
            <?php
                if($values['qty']*$value['price'] != $values['qty']*$value['disprice']){
            ?>
            <p>
                <span>US$</span>
                <span><?php echo $value['disprice'] ?></span>
            </p>
            <?php
                }
            ?>
        </li>
        <li class="orderLi4">
            <span class="subNum" data-uid="<?php echo $value['id'] ?>">--</span>
            <span>
                <input class="payNumber" type="text" value="<?php echo $values['qty']; ?>" />
            </span>
            <span class="addNum" data-uid="<?php echo $value['id'] ?>">+</span>
        </li>
        <li class="orderLi5">
            <span>US$</span>
            <span>
                <?php echo $values['qty']*$value['disprice']; ?>
                
                <?php
                    if($values['check'] == true){
                ?>
                <input class="disPriceInt" type="hidden" value="<?php echo $values['qty']*$value['disprice']; ?>">
                <input class="allPriceInt" type="hidden" value="<?php echo $values['qty']*$value['price']; ?>">
                <input class="savePrice" type="hidden" value="<?php echo $values['qty']*$value['price'] - $values['qty']*$value['disprice']; ?>">
                <?php
                    }else{
                ?>
                <input type="hidden" value="<?php echo $values['qty']*$value['disprice']; ?>">
                <input type="hidden" value="0">
                <input type="hidden" value="0">
                <?php
                    }
                ?>
            </span>
            <?php
                if($values['qty']*$value['price'] != $values['qty']*$value['disprice']){
            ?>
            <p>
                <span>You Save</span>
                <span>US$</span>
                <span>
                    <?php echo $values['qty']*$value['price'] - $values['qty']*$value['disprice'];?>
                </span>
                (<span><?php echo round((1-($values['qty']*$value['disprice'])/($values['qty']*$value['price']))*100,2)?>%</span>)
            </p>
            <?php
                }
            ?>
        </li>
        <li class="orderLi6 delOrder" data-uid="<?php echo $value['id'] ?>">
                                             删除
        </li>
    </ul>
        <?php
                    }
                }
            }
            }
        ?>
    <div class="priceData">
        <p class="priceDom priceDomsm">
            <span class="priceTxt">Subtotal: </span>
            <span> US$ </span>
            <span class="allTotal"></span>
        </p>
        <p class="priceDom priceDomsm">
            <span class="priceTxt">Discount: </span>
            <span> US$ -</span>
            <span class="saveTotal"></span>
        </p>
        <p class="priceDom">
            <span class="priceTxt">Total:</span>
            <span> US$</span>
            <span class="priceTotal"></span>
        </p>
    </div>