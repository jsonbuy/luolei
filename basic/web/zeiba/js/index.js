requirejs.config({
    baseUrl: 'web/js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/module'],function($,module){
	module.banner();
})
