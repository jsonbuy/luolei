<?php
$this->title = 'order pay';
$get = \Yii::$app->request->get();
?>
<div class="showCaseWarp">
    <ul class="lbUl paymentMessage">
        <li>
            <b class="paymentOrdernumber">提交订单成功，请您尽快付款！订单号：<?php echo $get['orderNumber']?></b>
            <p>请您在<span>24小时</span>内完成支付，否则订单会被自动取消</p>
        </li>
        <li class="paymentPrice">
            <p>应付金额<b>
            <?php echo $orderInf[0]['totalprice'] ?>
            </b>元</p>
        </li>
    </ul>
    <div class="paymentSelect">
        <h1>银行卡支付</h1>
        <div class="paymentClip">
            <input type="radio" />
            <span>银行卡</span>
            <span>中国建设银行</span>
            <span>添加新卡</span>
            <span>支付<b>
            <?php echo $orderInf[0]['totalprice'] ?>
            </b>元</span>
        </div>
        <h1>请输入6位数字支付密码</h1>
        <ul class="lbUl paymentPassword">
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
            <li><input class="passInput" maxlength="1" type="password" value="" /></li>
        </ul>
        <input class="btn btn-orange" type="button" value="立即支付" />
    </div>
</div>