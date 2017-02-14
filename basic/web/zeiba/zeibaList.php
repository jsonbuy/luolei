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
.viewbox , .pright3{max-width:1200px;width:100%;margin:0 auto;}
.boxoff+.content{display:none;}
.viewbox .picview{float:left;width:121px;height:170px;}
.viewbox .picview img{width:121px;height:170px;}
.viewbox .infolist{width:auto;margin-left:135px;}
.viewbox .content{clear:both;padding-top:0px;line-height:25px;font-size:14px;}
.viewbox .picview{position:relative;}
.viewbox .zhezhao{width:100%;height:30px;line-height:28px;position:absolute;left:0px;bottom:0px;background-color:#ef3f22;z-index:9;color:white;text-align:center;}
.infolist small{color:#256EB1;font-size:13px;font-weight:bold;height:27px;line-height:27px;}
.infolist span{height:27px;line-height:27px;font-size:13px;}
.pright3 a{padding:10px;background-color:#F5FAFF;border:1px dotted #B0C7DD;}
</style>
<?php
include_once('top.php');
?>
<?php
	$url = $_GET['url'];
	$content = file_get_contents($url);
	$content = mb_convert_encoding($content, 'utf-8', 'gbk');
	
	$preg = "#<div class=\"viewbox\">.*?<div class=\"pright3\">#ism";
	preg_match_all($preg, $content,$arr);
	foreach ($arr as $key =>$value) {
		echo $value[0];
	}
	$pregs = "#<ul class=\"downurllist\">.*<div class=\"boxoff\">#ism";
	preg_match_all($pregs, $content,$arrs);
	foreach ($arrs as $key =>$value) {
		$var =  $value[0];
		$pregk = "#<strong><a href=\"(.*)\".*?>(.*)<\/a><\/strong>#iUs";
		preg_match_all($pregk, $var,$arrb);
		echo '<a href="'.$zeibaurl.$arrb[1][0].'">本地高速下载</a>';
	}
?>
</div>
<?php
include_once('footer.php');
?>
<script src="js/lib/jquery.js"></script>
<script>
	$('.picview').append('<div class="zhezhao">斯帕克影视</div>');
</script>