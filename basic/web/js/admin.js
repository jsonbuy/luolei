requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/ancAdmin'/*,'/basic/ancdone/upload/plupload.full.min.js'*/],function($,admin){
	
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
