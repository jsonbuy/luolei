requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/order'],function($,order){
	order.orderPrice();
	order.orderListAjax();
    order.addDress();
    order.delDress();
    order.defaultDress();
    order.paymentPassword();
    order.orderPay();
})
