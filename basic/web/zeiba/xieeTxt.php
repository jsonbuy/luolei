<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" manifest="demo.appcache">
<?php
session_start();
	error_reporting(E_ERROR); 
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META name="keywords" content="斯帕克影视，斯帕克，spark，vipspark，斯帕克影视官网，电影资源共享，周星驰电影，成龙电影">
<META name="description" content="斯帕克影视是一个资源分享网站，由版主整理分享，欢迎各位收藏。">
<style>

.dy2018{max-width:1200px;width:100%;margin:0 auto;text-align:center;}
.content{line-height:22px;padding:5px;}
.content img{max-width:100%;margin:5px 0px;}
.title{font-size:16px;text-align:center;margin:15px 0px;}
.nextnoko{display:none;}
@media(max-width:768px){
	.dy2018{text-align:left;}
}
</style>
<?php
include_once('top.php');
?>
<?php
	if(isset($_GET['url']) == true){
		$code = true;
		$url = $_GET['url'];
	}else{
		//$code = false;
		//$url = $zeibaurl."/mh/2016/0808/89050.html";
	}
	$content = file_get_contents($url);
	
	// if(gzdecode(file_get_contents($url))){
		// $content = gzdecode(file_get_contents($url));
	// }else{
		// $content = file_get_contents($url);
	// }
	$con = mb_convert_encoding($content, 'utf-8', 'gbk');
	$preg = "#<div class=\"content\".*?>.*?<div class=\"dede_pages2\">#ism";
	preg_match_all($preg, $con,$arr);
?>
<div class="dy2018">
	<p class="title">斯帕克搞笑时刻</p>
	<ul class="lineBlock dyCon">
	<?php
		foreach ($arr as $key =>$value) {
			$var =  $value[0];
			echo $var;
		}
	?>
		
	</ul>
</div>

<?php
include_once('footer.php');
?>
<script src="js/lib/jquery.js"></script>
<script>
for(var i = 0 , leng = $('big').length; i < leng ; i++){
	if($('big').eq(i).children('a').length == 1){
		$('big').eq(i).children('a').attr('href','javascript:void(0);');
	}
}
for(var i = 0 ,leng = $('.pagelist').children('li').length ; i < leng ; i++){
	var pageLI = $('.pagelist').children('li').eq(i).children('a');
	var pageHref = pageLI.attr('href');
	pageLI.attr('href' , 'zeiba.php?url=http://www.zei8.net/txt/25/' + pageHref);
}
</script>
