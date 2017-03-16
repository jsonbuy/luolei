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
				if(result.status == 1){
					window.location = "index.php?r=ancadmin/index&page=index";
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
	function ClearNullArr(arr){ //去除数组中的空元素
        for(var i=0,len=arr.length;i<len;i++){
            if(!arr[i]||arr[i]==''||arr[i] === undefined){
                arr.splice(i,1); 
                len--; 
                i--; 
            } 
        } 
        return arr; 
    } 
	function onClicks(){
        $(document).on('click','.createSKU',function(){
            var arr = [];
            for(var i = 0; i < $('.productCheckbox').length; i++){
                var box = $('.productCheckbox').eq(i).children('.active');
                var arr1 = [];
                for(var k = 0; k < box.length; k++){
                    arr1.push(box.eq(k).data('att'));
                }
                arr.push(arr1);
            }
            arr = ClearNullArr(arr);
            var r = multiCartesian(arr,true);
            var html = "<span class='spuSpan lineBlock'>SPU</span><span class='spuDefault lineBlock'>DEFAULT</span><span class='skuSpan lineBlock'>SKU</span><span class='skuDelete lineBlock'>操作</span><ul>";
            var skustart = '';
            var spustart = '';
            var classData = '';
            var skuArr = '';
            var skuID = $('.skuID').data('skuid') + 1;
            for(var i = 0; i < $('.productEvent').length; i++){
                skustart += $('.productEvent').eq(i).children('.state').data('att');
                spustart += $('.productEvent').eq(i).children('.state').data('att') + '-';
                classData += $('.productEvent').eq(i).children('.state').data('att')+',';
            }
            for(var i = 0; i < r.length; i++){
                skuArr += skustart + skuID + '-' + r[i] + ',';
                if(i == 0){
                    html += "<li class='active'>";
                }else{
                    html += "<li>";
                }
                html += "<span class='spuSpan lineBlock'>"+ spustart + skuID +"</span><span class='spuDefault lineBlock'>";
                if(i == 0){
                    html += "<i class='defShow'>默认SKU</i>";
                }else{
                    html += "<i class='defShow'>默认SKU</i>";
                }
                html += "</span><span class='skuSpan lineBlock'>"+ skustart + skuID + '-' + r[i] +"</span>";
                html += "<span class='skuDelete lineBlock'>删除</span>";
                html += "</li>";
            }
            skuArr = skuArr.substring(0 , skuArr.length-1);
            html += "</ul><input id='skuArr' name='skuArr' type='hidden' value='"+ skuArr +"'>";
            
            
            var arrVal = [];
            for(var i = 0; i < $('.productCheckbox').length; i++){
                var box = $('.productCheckbox').eq(i).children('.active');
                var arr2 = [];
                for(var k = 0; k < box.length; k++){
                    arr2.push(box.eq(k).data('val'));
                }
                arrVal.push(arr2);
            }
            arrVal = ClearNullArr(arrVal);
            var skuDataArrs = multiCartesian(arrVal,false).join(' ');
            var skuDataArrs   = skuDataArrs.split(' ');
            var skuDataVals = "";
            for(var i = 0; i < skuDataArrs.length; i++){
                vas = skuDataArrs[i].split(',');
                for(var k = 0; k < vas.length; k++){
                    var nas = $('.attributeP').eq(k).data('val');
                    skuDataVals += nas + ":" + vas[k];
                    if(k < vas.length - 1){
                        skuDataVals += "|"
                    }
                }
                if(i < skuDataArrs.length - 1){
                    skuDataVals += ","
                }
            }
            html += '<input id="skuData" name="skuData" type="hidden" value="'+ skuDataVals +'">';
            $('.creatSKU').html(html);
        })
        $(document).on('click','.skuDelete',function(){
            var skuarr = $('#skuArr').val();
            var skuData = $('#skuData').val();
            var _index = $(this).parent('li').index();
                skuarr = skuarr.split(',');
                skuarr.splice(_index,1);
                $('#skuArr').val(skuarr);
                
                skuData = skuData.split(',');
                skuData.splice(_index,1);
                $('#skuData').val(skuData);
            $(this).parent('li').remove();
        })
        $(document).on('click', '.defShow', function(){
            var _index = $(this).parents('li').index();
            $(this).parents('li').addClass('active');
            $(this).parents('li').siblings().removeClass('active');
            $('input[name=default]').val(_index);
        })
        $(document).on('click', '.imgRadio', function(){
            $('.imgRadio').removeClass('active');
            $('.imgDefault').val('0');
            $(this).addClass('active');
            $(this).siblings('.imgDefault').val('1');
        })
	}
    function events(){
        $('.productEvent li').click(function(){
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            $(this).siblings().removeClass('state');
            $(this).parents('tr').nextAll('.brandTR').hide();
        });
        $('.productCheckbox li').click(function(){
            $(this).toggleClass('active');
        });
    }
    function classAjax(_this,id,url){
        if(_this.hasClass('state') == false){
            var nextTR = _this.parents('tr').next('tr');
            $.ajax({
                type : 'post',
                url : url,
                data : {id:id},
                dataType : 'json',
                success : function(result){
                    if(result.ret == 1){
                        _this.addClass('state');
                        nextTR.show();
                        nextTR.children('.brandBox').html(result.data);
                    }else{
                        _this.parents('tr').nextAll('.brandTR').hide();
                    }
                    events();
                }
            })
        }
    }
    function eventAjax(){
        $('.productClass li').click(function(){
            var _this = $(this);
            var id = $(this).data('id');
            var url = 'index.php?r=ancadmin/selectbrand';
            classAjax(_this,id,url);
        }) 
        $(document).on('click','.productbrand li',function(){
            var _this = $(this);
            var id = $(this).data('id');
            var url = 'index.php?r=ancadmin/selectclassify';
            classAjax(_this,id,url);
        })
        $(document).on('click','.productclassify li',function(){
            var _this = $(this);
            var id = $(this).data('att');
            var url = 'index.php?r=ancadmin/selectattribute';
            classAjax(_this,id,url);
        })
    }
	//=========================多图上传js===============================//
	
    
	return{
		ancLogin      : ancLogin,
		updateBanner  : updateBanner,
		deleteBanner  : deleteBanner,
		events        : events,
		eventAjax     : eventAjax,
		onClicks      : onClicks,
		deleteProImg  : deleteProImg,
		productInf    : productInf,
		searchSku     : searchSku
	}
});

















