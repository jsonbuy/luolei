<?php
use yii\web\session;
$this->title = 'order page';
$session = \yii::$app->session;
?>
<div class="showCaseWarp">
    <h1>新增收货地址</h1>
    <?php
        if(isset($session['username'])){
    ?>
    <form method="post" enctype="multipart/form-data">
    <ul class="shappingAdd lbUl">
        <li>
            <span class="shippText">姓*</span>
            <input name="firstName" type="text" />
        </li>
        <li>
            <span class="shippText">名*</span>
            <input name="lastName" type="text" />
        </li>
        <li>
            <span class="shippText">省份*</span>
            <input name="country" type="text" />
        </li>
        <li>
            <span class="shippText">市*</span>
            <input name="city" type="text" />
        </li>
        <li>
            <span class="shippText">详细地址*</span>
            <input name="address" type="text" />
        </li>
        <li>
            <span class="shippText">手机号码*</span>
            <input name="phoneNumber" type="text" />
        </li>
    </ul>
    <p class="addSub">
        <span>
            <input name="checkDefault" type="checkbox" />设置为默认地址
        </span>
        <input name="addDress" id="addAress" type="button" value="添加" />
    </p>
    </form>
    <?php
        }else{
    ?>
    <p>请登录</p>
    <?php
        }
    ?>
    <h1>收货人信息</h1>
    <div class="addressBox">
    <?php
        foreach ($adressInf as $key => $value) {
    ?>
    <ul class="shappingAress lbUl">
        <li class="addressTxt">
            <input name="radioDress" type="radio" />
            <span class="shippText">Name: 
                <?php echo $value['firstName'].' '.$value['lastName']?>
            </span>
            <span class="shippText">Address:
                <?php echo $value['country'].' '.$value['city'].' '.$value['address']?>
            </span>
            <span class="shippText">Phone Number:
                <?php echo $value['phoneNumber']?>
            </span>
            <input type="hidden" class="order_address" value="<?php echo $value['firstName'].$value['lastName'].'-'.$value['country'].$value['city'].$value['address'].'-'.$value['phoneNumber']?>" />
        </li>
        <li class="default" data-default="<?php echo $value['default']?>">DEFAULT</li>
        <li class="addressRemove" data-id="<?php echo $value['id']?>">
                                           删除地址
        </li>
    </ul>
    <?php
        }
    ?>
    </div>
    <h1>支付方式</h1>
    <ul class="lbUl payment">
        <?php
            foreach ($orderPayment as $key => $value) {
        ?>
        <li data-key="<?php echo $value['key'] ?>"><?php echo $value['name'] ?></li>
        <?php
            }
        ?>
    </ul>
    <h1>送货清单</h1>
    <ul class="lbUl orderUl orderTitle">
        <li class="orderLi0">选择</li>
        <li class="orderLi1">Item</li>
        <li class="orderLi2"></li>
        <li class="orderLi3">Price</li>
        <li class="orderLi4">Qty</li>
        <li class="orderLi5">Total</li>
        <li class="orderLi6">操作</li>
    </ul>
    <?php
        if(isset($session['username'])){
    ?>
    <div id="orderList"></div>
    <input type="hidden" id="orderUser" value="<?php echo $session['username']?>" />
    <?php
        }
    ?>
    <p class="shoppingBtn">
        <span class="address"></span>
        <input type="button" value="Continue Shopping" />
    </p>
</div>