requirejs.config({
    baseUrl: 'js/lib',
    paths: {
        app: '../app'
    }
});

require(['jquery','app/buy'],function($){

})
