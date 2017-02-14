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
})

require(['jquery','productImg','app/order'],function($,img,order){
    $('.buyNow').click(function(){
        order.orderAjax();
    })
	$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	$('.productSmallmove').children('li').eq(0).addClass('cpActive');
})
