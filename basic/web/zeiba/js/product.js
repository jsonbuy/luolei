requirejs.config({
    baseUrl: 'web/js/lib',
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

require(['jquery','productImg'],function($,img){
	$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	$('.productSmallmove').children('li').eq(0).addClass('cpActive');
})