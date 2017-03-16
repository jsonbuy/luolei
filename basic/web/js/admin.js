requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/common','app/ancAdmin','descartes'],function($,common,admin){
	admin.events();
	admin.eventAjax();
	admin.onClicks();
    common.evens();
	$("#login").click(function(){
		admin.ancLogin();
	})
	$("input[name=updateBanner]").click(function(){
		var _this = $(this);
		admin.updateBanner(_this);
	})
	$("input[name=deleteBanner]").click(function(){
		var _this = $(this);
		admin.deleteBanner(_this);
	})
	$("#porinf").click(function(){
		admin.productInf();
	})
	$(document).on('click','.delProImg',function(){
		var _this = $(this);
		admin.deleteProImg(_this);
	})
	$('#searchSKU').click(function(){
		admin.searchSku();
	})
	
})
