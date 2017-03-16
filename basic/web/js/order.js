requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/common','app/order'],function($,common,order){
	order.orderPrice();
	order.orderListAjax();
    order.addDress();
    order.delDress();
    order.defaultDress();
    order.paymentPassword();
    order.orderPay();
    common.evens();
})
