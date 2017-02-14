define(['jquery'],function ($) {
	/**
	 * 确认框
	 * @param fun 点击确认后要执行的函数
	 * @param contents 提示框显示的内容
	 */
	function Dialog(fun,titles,contents){
		var params ={title : titles || '',content : contents || '',button1:'Cancel',button2:'Ok'};	
		params = $.extend({'position':{'zone':'center'},'overlay':true}, params);
		var id = 'dialogBox_' + Math.floor(Math.random() * 1e9);
		var markup = [
	        '<div id="' + id + '"  class="pu_pop">',
				'<div class="pu_popWarp">',
					'<p class="pu_popTitle">',
						params.title,
					'</p>',
					'<div class="pu_popCon">',
						params.content,
					'</div>',
					'<p class="pu_popBtn">',
						'<a class="btn cancelC" href="javascript:;">',params.button1,'</a>',
						'<a class="btn btn-primary" tag="ok" href="javascript:;">',params.button2,'</a>',
					'</p>',
				'</div>',
				'<p class="empty"> </p>',
				'<div class="pu_popBlack"> </div>',
			'</div>'
	    ].join('');
	    $(markup).hide().appendTo('body').fadeIn();
	    if($.isFunction(fun)){
	    	$('#' + id).find('a[tag=ok]').click(fun);
	    }
		$(".closePop").click(function(){
			$(".pu_pop").fadeOut(function(){
				$(this).remove();
			});
		})
		$(".pu_popBlack,.cancelC").click(function(){
			var con = $(this).parents(".pu_pop");
			con.fadeOut(function(){
				con.remove();
			});
		})
	}
	function ancLogin(){
		var email = $('input[name="user"]').val();
		var pw = $('input[name="pass"]').val();
		$.ajax({
			type : 'post',
			url : 'index.php?r=ancadmin/login',
			data : {email:email,pw:pw},
			dataType : 'json',
			success : function(result){
				if(result.status==1){
					window.location="index.php?r=ancadmin/index&page=index";
				}else if(result.status==0){
					$('input[name="pass"]').siblings(".help-block").text("用户名或密码不正确");
					$('.controls').addClass('error');
				}
			}
		})
	}
	/**
	 * 修改后台banner
	 */
	function updateBanner(_this){
		var ids = _this.siblings('input[name="bannerId"]').val();
		var title = _this.parents('tr').find('input[name="bannerTitle"]').val();
		var imgurl = _this.parents('tr').find('input[name="bannerUrl"]').val();
		$.ajax({
			type : 'post',
			url : 'index.php?r=ancadmin/updatebanner',
			data : {id:ids,title:title,imgurl:imgurl},
			dataType : 'json',
			success : function(result){
				if(result.status==1){
					Dialog(function(){
						var con = $(this).parents(".pu_pop");
						con.fadeOut(function(){
							con.remove();
						});
					},"tip",result.message);
				}else if(result.status==0){
					Dialog(function(){
						var con = $(this).parents(".pu_pop");
						con.fadeOut(function(){
							con.remove();
						});
					},"tip",result.message);
				}
			}
		})
	}
	/**
	 * 删除banner
	 */
	function deleteBanner(_this){
		var ids = _this.parents('.edibanner').find('input[name="bannerId"]').val();
		var banner = _this.parents('.edibanner').find('.imgbanner').attr('src');
		$.ajax({
			type : 'post',
			url : 'index.php?r=ancadmin/deletebanner',
			data : {id:ids,banner:banner},
			dataType : 'json',
			success : function(result){
				if(result.status==1){
					window.location="index.php?r=ancadmin/index&page=index";
				}else if(result.status==0){
					Dialog(function(){
						var con = $(this).parents(".pu_pop");
						con.fadeOut(function(){
							con.remove();
						});
					},"tip",result.message);
				}
			}
		})
	}
	/**
	 * 删除produxtImg
	 * 删除上传时 产品图片
	 */
	
	function deleteProImg(_this){
		var urls = _this.siblings('.img').children('img').attr('src');
		var imgName = _this.siblings('p').text();
		console.log(imgName)
		var imgArray = $('.imgArray').val();
		var imgArray = (imgArray.split(","));
		imgArray.splice($.inArray(imgName,imgArray),1);
		_this.parents('li').remove();
		$('.imgArray').val(imgArray);
		$.ajax({
			type : 'post',
			url : 'index.php?r=ancadmin/deleteproimg',
			data : {urls:urls},
			dataType : 'json',
			success : function(result){
				if(result.status==1){
					_this.parent('li').remove();
				}
			}
		})
	}
	/**
	 * 删除produxtImg
	 * 删除上传时 产品图片
	 */
	function productInf(){
		var inserts = $('#proinfForm').submit();
		if(inserts){
			Dialog(function(){
				var con = $(this).parents(".pu_pop");
				con.fadeOut(function(){
					con.remove();
				});
			},"tip",'上传成功');
		}
	}
	/**
	 * 搜索SKU
	 */ 
	function searchSku(){
		var sku = $('input[name=prosearch]').val();
		window.location = "index.php?r=ancadmin/index&page=productsearch&sku="+sku;
		// $.ajax({
			// type : 'post',
			// url : 'index.php?r=ancadmin/searchsku',
			// data : {sku:sku},
			// dataType : 'json',
			// success : function(result){
				// // if(result.status==1){
					// // window.location = "index.php?r=ancadmin/index&page=productupdate&sku="+sku;
				// // }
			// }
		// })
	}
    
	//=========================多图上传js===============================//
	
    
	return{
		ancLogin      : ancLogin,
		updateBanner  : updateBanner,
		deleteBanner  : deleteBanner,
		//uploader      : uploader,
		deleteProImg  : deleteProImg,
		productInf    : productInf,
		searchSku     : searchSku
	}
});

















