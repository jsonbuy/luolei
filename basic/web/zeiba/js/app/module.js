define(['jquery'],function ($) {
	function banner(){
		var interval=0;
		var now=0;
		var warp = $('.bannerIn');
		var box = warp.children('.bannerImg');
		var banners = box.children('li');
		var pointLi = '';
		
		for(var i=0;i<banners.length;i++){
			pointLi += '<li class="lineBlock"></li>'
		}
		box.after('<ul class="bannerPoint">'+pointLi+'</ul><span class="leftClick"></span><span class="rightClick"></span>');
		
		var point = $('.bannerPoint').children('li');
		var lc = box.siblings('.leftClick');
		var rc = box.siblings('.rightClick');
		
		point.eq(0).addClass('active');
		function banner(now,next){
			var currObj=banners.eq(now);
			var nextObj=banners.eq(next);
			currObj.stop(true).fadeOut(1000);
			nextObj.stop(true).fadeIn(1000);
			point.removeClass("active");
		}
		function playBanner()
		{
			clearInterval(interval);
			interval=setInterval(function()
			{
				if(banners.length <= 1) clearInterval(interval);
				next= now+1 >= banners.length ? 0 : now+1;
				banner(now,next);
				point.eq(next).addClass("active");
				now=next;
		    	return false;
			},7000)
		};
		playBanner();
		warp.mouseover(function(){
			clearInterval(interval);
		})
		warp.mouseleave(function(){
			playBanner();
		})
		point.hover(function(){
			if (!banners.is(":animated")) { 
				var index=$(this).prevAll("li").length;
				if(index == now) return;
				clearInterval(interval);
				banner(now,index);
				$(this).addClass("active");
				now=index;
				playBanner();
			}
		})
		lc.click(function(){
			if (!banners.is(":animated")) { 
				var index=warp.find(".active").index();
				prev= index-1 < -1 ? banners.length : index-1;
				banner(now,prev);
				point.eq(prev).addClass("active");
				now=prev;
				playBanner();
			}
		})
		rc.click(function(){
			if (!banners.is(":animated")) { 
				var index=warp.find(".active").index();
				next= now+1 >= banners.length ? 0 : now+1;
				banner(now,next);
				point.eq(next).addClass("active");
				now=next;
				playBanner();
			}
		})
	}
	return{
		banner:banner
	}
});

















