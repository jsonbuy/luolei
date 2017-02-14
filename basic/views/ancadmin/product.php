<?php
use yii\widgets\ActiveForm;
use app\ancdone\code\AncHelper;
?>
<form method="post" id="proinfForm" action="index.php?r=ancadmin/proinf&page=product" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="0" border="0" class="productTable">
	<tr>
		<td>图片</td>
		<td>
			<div class="container">
	            <div class="demo">
	                <a class="btn" id="btn">上传图片</a> 最大500KB，支持jpg，gif，png格式。
	                <ul id="ul_pics" class="ul_pics clearfix"></ul>
	            </div>
	        </div>
		</td>
	</tr>
	<tr>
		<td>标题</td>
		<td>
			<textarea name="title"></textarea>
		</td>
	</tr>
	<tr>
		<td>SKU</td>
		<td>
			<input name="sku" type="text" />
		</td>
	</tr>
	<tr>
		<td>原价</td>
		<td>
			<input name="price" type="text" />
		</td>
	</tr>
	<tr>
		<td>折扣价格</td>
		<td>
			暂无
		</td>
	</tr>
	<tr>
		<td>仓库</td>
		<td>
			暂时可前端设置统一
		</td>
	</tr>
	<tr>
		<td>是否免邮</td>
		<td>
			暂时可前端设置统一
		</td>
	</tr>
	<tr>
		<td>库存</td>
		<td>
			<input name="qty" type="text" />
		</td>
	</tr>
	<tr>
		<td>产品描述</td>
		<td>
			<textarea name="productInf"></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input id="porinf" class="btn btn-primary" type="button" value="Submit" />
		</td>
	</tr>
</table>
</form>
<script src="<?php echo AncHelper::settingPath() ?>/web/js/lib/jquery.js"></script>
<script src="<?php echo AncHelper::settingPath() ?>/ancdone/upload/plupload.full.min.js"></script>
<script>
	var imgArray = [];
    var uploader = new plupload.Uploader({//创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'btn', // 上传按钮
        url: "index.php?r=ancadmin/upproductimg", //远程上传地址
        flash_swf_url: 'plupload/Moxie.swf', //flash文件地址
        silverlight_xap_url: 'plupload/Moxie.xap', //silverlight文件地址
        filters: {
            max_file_size: '500kb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
            mime_types: [//允许文件上传类型
                {title: "files", extensions: "jpg,png,gif"}
            ]
        },
        multi_selection: true, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                if ($("#ul_pics").children("li").length > 10) {
                    alert("您上传的图片太多了！");
                    uploader.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                    });
                    $("#ul_pics").append(li);
                    uploader.start();
                }
            },
            UploadProgress: function(up, file) { //上传中，显示进度条
         var percent = file.percent;
                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                $("#" + file.id).find(".percent").text(percent + "%");
            },
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
               var data = eval("(" + info.response + ")");
                $("#" + file.id).html("<span class='close delProImg'></span><div class='img'><img src='" + data.pic + "'/></div><p>" + data.name + "</p>");
                imgArray.push(data.name);
                $('#ul_pics').append("<input class='imgArray' type='hidden' name='imgArray' value='"+imgArray+"' >");
                $('.imgArray').prevAll('.imgArray').remove();
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
	uploader.init();
</script>