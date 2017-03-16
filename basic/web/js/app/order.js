define(['jquery','app/common'],function ($,common) {
    var basic = '/basic/web';
	function orderAjax(){
	    var id = $('#uid').val();
        var qty = $('#quantity').val();
		$.ajax({
             url : basic + '/index.php?r=order/orderajax',
             timeout : 10000,
             type : 'get',
             data : {id:id,qty:qty,},
             dataType : 'json',
             success : function(data) {
                 if(data.ret == 1){
                     window.location.href = basic + '/index.php?r=order/order';
                 }else if(data.ret == 2){
                     alert('请登录');
                 }
             }
         });
	};
	function orderPrice(){
	    var priceDom = $('.disPriceInt');
        var saveDom = $('.savePrice');
        var priceTos = $('.allPriceInt');
	    var price = 0;
	    var savePri = 0;
        var totalPri = 0;
	    for(var i = 0; i < priceDom.length; i++){
	        price += parseFloat(priceDom.eq(i).val());
	        totalPri += parseFloat(priceTos.eq(i).val());
	    }
        for(var i = 0; i < saveDom.length; i++){
            savePri += parseFloat(saveDom.eq(i).val());
        }
	    $('.priceTotal').text(price.toFixed(2));
        $('.saveTotal').text(savePri.toFixed(2));
        $('.allTotal').text(totalPri.toFixed(2));
	};
    function orderList(){
         $.ajax({
             url : basic + '/index.php?r=order/orderlist',
             timeout : 10000,
             type : 'get',
             dataType : 'html',
             success : function(data) {
                 $('#orderList').html(data);
                 countClick();
                 orderPrice();
             }
         });
    }
    function orderListAjax(){
        if($('#orderList').children().length == 0){
           orderList();
         }
    }
    function countClick(){
        var add = $('.addNum');
        var sub = $('.subNum');
        var del = $('.delOrder');
        var check = $('.checkInput').children('input');
        add.click(function(){
            var plist = JSON.parse(common.getCookie('plist'));
            var clickData = $(this).data('uid');
            for(var i = 0; i < plist.length; i++){
                if(plist[i].uid == clickData){
                    plist[i].qty = parseInt(plist[i].qty) + 1;
                }
            }
            plist = JSON.stringify(plist);
            common.setCookie('plist',plist,360);
            orderList();
        });
        sub.click(function(){
            var plist = JSON.parse(common.getCookie('plist'));
            var clickData = $(this).data('uid');
            for(var i = 0; i < plist.length; i++){
                if(plist[i].uid == clickData && parseInt(plist[i].qty) > 1){
                    plist[i].qty = parseInt(plist[i].qty) - 1;
                }
            }
            plist = JSON.stringify(plist);
            common.setCookie('plist',plist,360);
            orderList();
        });
        del.click(function(){
            var plist = JSON.parse(common.getCookie('plist'));
            var clickData = $(this).data('uid');
            for(var i = 0; i < plist.length; i++){
                if(plist[i].uid == clickData){
                    plist.splice(i,i+1);
                }
            }
            plist = JSON.stringify(plist);
            common.setCookie('plist',plist,360);
            orderList();
        });
        check.click(function(){
            var plist = JSON.parse(common.getCookie('plist'));
            var clickData = $(this).data('uid');
            for(var i = 0; i < plist.length; i++){
                if(plist[i].uid == clickData){
                    if(plist[i].check == true){
                        plist[i].check = false;
                    }else{
                        plist[i].check = true;
                    }
                }
            }
            plist = JSON.stringify(plist);
            common.setCookie('plist',plist,360);
            orderList();
        });
    }
	function orderPay(){
	    var pay = $('.shoppingBtn').children('input');
	    pay.click(function(){
	        if($('.disPriceInt').length == 0){
	            alert('请选择商品');
	            return;
	        }
	        if($('.payment .active').length == 0){
	            alert('请选择支付方式');
	            return;
	        }
	        if($('.disPriceInt').length > 0 && common.getCookie('payment')){
	            var id = '';
	            for(var i = 0; i < $('.selectProduct').length; i++){
	                id += $('.selectProduct').eq(i).data('uid')+'-'+$('.selectProduct').eq(i).parents('.orderCon').find('.payNumber').val()+',';
	            }
	            id = id.substring(0,id.length-1);
	            var user = $('#orderUser').val();
	            var address = $('.address').text();
	            var payment = common.getCookie('payment');
	            var priceTotal = $('.priceTotal').text();
	            $.ajax({
                     url : basic + '/index.php?r=order/createorder',
                     timeout : 10000,
                     type : 'get',
                     data : {id:id,user:user,address:address,payment:payment,priceTotal:priceTotal},
                     dataType : 'json',
                     success : function(data) {
                         if(data.ret == 1){
                             common.delCookie('plist');
                             window.location = "index.php?r=order/orderpay&orderNumber="+data.orderNumber;
                         }
                     }
                 });
	        }
	    })
	};
	function addDress(){
	    $('#addAress').click(function(){
	        var firstName   = $('input[name=firstName]').val(),
	            lastName    = $('input[name=lastName]').val(),
	            country     = $('input[name=country]').val(),
	            address     = $('input[name=address]').val(),
	            city        = $('input[name=city]').val(),
	            phoneNumber = $('input[name=phoneNumber]').val(),
	            checkDefault= 0;
	            if($('input[name=checkDefault]').is(':checked') == true){
	                checkDefault = 1;
	            }
    	        $.ajax({
                     url : basic + '/index.php?r=order/addadress',
                     timeout : 10000,
                     type : 'get',
                     data : {firstName:firstName,lastName:lastName,country:country,address:address,city:city,phoneNumber:phoneNumber,checkDefault:checkDefault},
                     success : function() {
                         window.location = window.location.href;
                     }
                 });
	    })
	};
    function delDress(){
        $('.addressRemove').click(function(){
            var id = $(this).data('id');
            var _this = $(this);
            $.ajax({
                 url : basic + '/index.php?r=order/deletdress',
                 timeout : 10000,
                 type : 'get',
                 data : {id:id},
                 success : function() {
                     _this.parent('.shappingAress').remove();
                 }
             });
        })
    };
    function defaultDress(){
        var defaults = $('.default');
        var address = $('.shoppingBtn').children('.address');
        var radioDress = $('input[name=radioDress]');
        for(var i=0; i<defaults.length; i++){
            if(defaults.eq(i).data('default') == 1){
                defaults.eq(i).addClass('active');
                defaults.eq(i).siblings('.addressTxt').children('input').attr("checked","checked");
                address.text($('.order_address').eq(i).val());
            }
        };
        $('input[name=radioDress]').click(function(){
            $('input[name=radioDress]').checked = false;
        });
        radioDress.click(function(){
            var index = $(this).parents('.shappingAress').index();
            address.text($('.order_address').eq(index).val());
        });
        defaults.click(function(){
            var id = $(this).next().data('id');
            var _this = $(this);
            $.ajax({
                 url : basic + '/index.php?r=order/updatadress',
                 timeout : 10000,
                 type : 'get',
                 data : {id:id},
                 success : function() {
                     defaults.removeClass('active');
                     _this.addClass('active');
                 }
             });
        });
        $('.payment li').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            var payment = $(this).data('key');
            common.setCookie('payment',payment,360);
        });
        if(common.getCookie('payment')){
            var keyCookie = common.getCookie('payment');
            for(var i = 0; i < $('.payment').children('li').length; i++){
                if($('.payment').children('li').eq(i).data('key') == keyCookie){
                    $('.payment').children('li').removeClass('active');
                    $('.payment').children('li').eq(i).addClass('active');
                }
            }
        };
    };
    function paymentPassword(){
        var inputs = $('.passInput');
            inputs.click(function(){
                for(var i = 0; i < inputs.length; i++){
                    if(inputs.eq(i).val() == ''){
                        inputs.eq(i).focus();
                        return;
                    }
                }
            })
            inputs.keyup(function(e){
                var indexs = $(this).parent().index();
                this.value = this.value.replace(/[^0-9]/g,'');
                if($(this).val() != ''){
                    inputs.eq(indexs+1).focus();
                }
                if(e.keyCode == 8 && indexs > 0){
                    if(indexs == 5){
                        inputs.eq(indexs-1).focus();
                    }
                    inputs.eq(indexs-1).focus();
                }
            })
    }
	return{
		orderAjax  : orderAjax,
		orderListAjax   : orderListAjax,
		paymentPassword : paymentPassword,
		addDress   : addDress,
		delDress   : delDress,
		defaultDress:defaultDress,
		orderPay   : orderPay,
		orderPrice : orderPrice
	}
});

















