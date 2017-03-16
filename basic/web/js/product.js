requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require.config({
　　　shim: {
　　　　'CloudZoom': {
　　　　　　deps: ['productImg'],
　　　　　　exports: 'jQuery.fn.CloudZoom'
　　　　}
　　}
});

require(['jquery','app/common','productImg','app/order'],function($,common,img,order){
    common.evens();
    $('.buyNow').click(function(){
        order.orderAjax();
    })
	$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	$('.productSmallmove').children('li').eq(0).addClass('cpActive');
})
