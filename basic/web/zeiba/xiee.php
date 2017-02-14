<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" manifest="demo.appcache">
<?php
session_start();
	//error_reporting(E_ERROR); 
?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META name="keywords" content="斯帕克影视，斯帕克，spark，vipspark，斯帕克影视官网，电影资源共享，周星驰电影，成龙电影">
<META name="description" content="斯帕克影视是一个资源分享网站，由版主整理分享，欢迎各位收藏。">
<style>

.dy2018{max-width:1200px;width:100%;margin:0 auto;}
.e8 {text-align:center;margin-top:10px;}
.e8 li{display:inline-block;width:230px;height:210px;border:1px solid #ccc;padding:2px;vertical-align:top;margin:5px;overflow:hidden;}
.e8 li img{width:100%;}
.e8 li a,.e8 li span{display:block;text-align:center;}
.e8 li a{margin-bottom:8px;}
.pagelist{margin-top:20px;}
.pagelist li{margin-bottom:8px;display:inline-block;}
.pagelist li a{padding:5px;}
.pagelist li a:hover{background-color:#1FBEE8;color:white;}
.pagelist li.thisclass{color:red;}
@media(max-width:320px){
	.e8 li{display:inline-block;width:230px;height:210px;border:1px solid #ccc;padding:2px;vertical-align:top;margin:5px;}	
}
@media(min-width:320px) and (max-width:450px){
	.e8 li{display:inline-block;width:46%;height:210px;border:1px solid #ccc;padding:2px;vertical-align:top;margin:5px 1%;}
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
		$code = false;
		$url = $zeibaurl."/mh/list_178_1.html";
	}
	$content = file_get_contents($url);
	
	// if(gzdecode(file_get_contents($url))){
		// $content = gzdecode(file_get_contents($url));
	// }else{
		// $content = file_get_contents($url);
	// }
	$con = mb_convert_encoding($content, 'utf-8', 'gbk');
	$preg = "#<div class=\"listbox\".*?>.*?<div class=\"first\">#ism";
	preg_match_all($preg, $con,$arr);
?>
<div class="dy2018">
	<ul class="lineBlock dyCon">
	<?php
		foreach ($arr as $key =>$value) {
			$var =  $value[0];
			$var = preg_replace("/贼吧*/", "斯帕克", $var);
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
for(var i = 0 , leng = $('.e8 li').length; i < leng ; i++){
	//if($('.e8 li').eq(i).children('a').length == 1){
		var urls = $('.e8 li').eq(i).children('a').attr('href');
		$('.e8 li').eq(i).children('a').attr('href','xieeTxt.php?url='+ $zeibaurl + urls);
	//}
}
for(var i = 0 ,leng = $('.pagelist').children('li').length ; i < leng ; i++){
	var pageLI = $('.pagelist').children('li').eq(i).children('a');
	var pageHref = pageLI.attr('href');
	pageLI.attr('href' , 'xiee.php?url='+ $zeibaurl + '/mh/' + pageHref);
}
</script>
