requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/common','app/module'],function($,common,module){
	module.banner();
    common.evens();
})
