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
.dy2018{max-width:1200px;width:100%;margin:0 auto;}

.toplantxt{}
.toplantxt dl{display:inline-block;width: 75px;height: 25px;background: #cc5555;border-radius: 6px;line-height: 25px;margin: 0px 5px 0 8px;float:left;}
.toplantxt dl a{color:white;display:block;text-align:center;}
.toplantxt ul{margin-left:100px;margin-top:15px;}
.toplantxt ul li{display:inline-block; width: 75px;height: 25px;background: #2192D1;border-radius: 10px;line-height: 25px;margin: 0px 5px 0 11px;margin-bottom:10px;}
.toplantxt ul li a{color:white;display:block;text-align:center;}
.toplantxt .girl{background-color:#f57da5;}
.toplantxt .c6 li:hover{background-color:#00749e;}

.pleft{display:inline-block;width:70%;display:inline-block;font-size:0px;*word-spacing:-1px;vertical-align:top;}
.pright{display:inline-block;margin-left:-5px;vertical-align:top;width:30%;border:1px solid #ccc;vertical-align:top;}
.xsnew{width:50%;display:inline-block;zoom:1;*display:inline;font-size:12px;letter-spacing:normal;word-spacing:normal;vertical-align:top;border:1px solid #ccc;margin-right:-1px;}
.xsnew dd{height:420px;padding:5px 15px;}
.xsnew dt{text-align:center;padding:8px 5px;border-bottom:1px solid #ccc;}
.w960{color:#06a7e1;margin-top:20px;}
.w960 a{color:#06a7e1;}
.w960 a:hover{color:#ef3f22;}
.usercenter .tbox dd {height: 422px;display: none;height:420px;}
.usercenter .tbox dd#uc_digg {display: block;}
.usercenter dt{text-align:center;padding:8px 5px;border-bottom:1px solid #ccc;}
.d2 li,.f1 li{line-height:28px;}
.d2 li .date{float:right;}

.xspic{margin-top:20px;text-align:center;}
.xspic dt{padding:8px;border:1px solid #ccc;margin-bottom:-1px;}
.e1{padding:10px;border:1px solid #ccc;}
.e1 li{display:inline-block;margin:5px;padding:2px;border:1px solid #ccc;}

.listboxind{margin-top:20px;}
.tboxind{width:33.3%;display:inline-block;border:1px solid #ccc;margin-top:-1px;margin-left:-1px;}
.tboxind .d1{line-height:20px;}
.tboxind .d1 span{float:right;}
.tboxind dt{padding:5px 10px;}
.tboxind dd{padding:10px;}
.tboxind .d6{height:130px;overflow:hidden;}
.tboxind .d6 li >a{float:left;padding:2px;border:1px solid #ccc;margin-right:10px;}
.tboxind .d6 span a{font-size:14px;font-weight:bold;margin-bottom:10px;display:block;}
.tboxind .d6 .infoind{margin-left:125px;color:#666;line-height:18px;max-height:75px;overflow:hidden;}
.tboxind strong a{display:block;font-size:16px;color:#ef3f22;}

.light .active{color:red;}
@media (max-width:768px){
	.pleft,.pright,.xsnew,.tboxind{width:100%;}
}
</style>

<?php
include_once('top.php');
	if(isset($_GET['url'])){
		$code = true;
		$url = $_GET['url'];
	}else{
		$code = false;
		$url = $zeibaurl."/txt/";
	}
	//$content = file_get_contents($url);
	if(gzdecode(file_get_contents($url))){
		$content = gzdecode(file_get_contents($url));
	}else{
		$content = file_get_contents($url);
	}
	//$content = gzdecode(file_get_contents($url));
	$con = mb_convert_encoding($content, 'utf-8', 'gbk');
	$preg = "#<div class=\"toplantxt\">(.*)<div class=\"flink2\">#ism";
	preg_match_all($preg, $con,$arr);
?>
<div class="dy2018">
<div>
<div>
	<?php
		foreach ($arr[0] as $key =>$value) {
			$var =  $value;
			echo $var;
		}
include_once('footer.php');
	?>
	
</div>
<script src="js/lib/jquery.js"></script>
<script>
for(var i = 0 , leng = $('.c6').children('li').length; i < leng ; i++){
	if($('.c6').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.c6').children('li').eq(i).children('a').attr('href');
		$('.c6').children('li').eq(i).children('a').attr('href','txtList.php?url='+ $zeibaurl  + c6Href);
	}
}
for(var i = 0 , leng = $('.tboxind').length; i < leng ; i++){
	if($('.tboxind').eq(i).children('dt').find('a').length == 1){
		var c6Href = $('.tboxind').eq(i).children('dt').find('a').attr('href');
		$('.tboxind').eq(i).children('dt').find('a').attr('href','txtList.php?url='+ $zeibaurl  + c6Href);
	}
}
for(var i = 0 , leng = $('.d1').children('li').length; i < leng ; i++){
	if($('.d1').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.d1').children('li').eq(i).children('a').attr('href');
		$('.d1').children('li').eq(i).children('a').attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href);
	}
}
for(var i = 0 , leng = $('.e1').children('li').length; i < leng ; i++){
	if($('.e1').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.e1').children('li').eq(i).children('a').attr('href');
		$('.e1').children('li').eq(i).children('a').attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href);
	}
}
for(var i = 0 , leng = $('.f1').children('li').length; i < leng ; i++){
	if($('.f1').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.f1').children('li').eq(i).children('a').attr('href');
		$('.f1').children('li').eq(i).children('a').attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href);
	}
}
for(var i = 0 , leng = $('.d2').children('li').length; i < leng ; i++){
	var c6Href = $('.d2').children('li').eq(i).children('a').eq(0).attr('href');
	var c6Href1 = $('.d2').children('li').eq(i).children('a').eq(1).attr('href');
	$('.d2').children('li').eq(i).children('a').eq(0).attr('href','txtList.php?url='+ $zeibaurl  + c6Href);
	$('.d2').children('li').eq(i).children('a').eq(1).attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href1);
}
for(var i = 0 , leng = $('.d6').children('li').length; i < leng ; i++){
	var c6Href = $('.d6').children('li').eq(i).find('a').eq(0).attr('href');
	var c6Href1 = $('.d6').children('li').eq(i).find('a').eq(1).attr('href');
	$('.d6').children('li').eq(i).find('a').eq(0).attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href);
	$('.d6').children('li').eq(i).find('a').eq(1).attr('href','zeibaList.php?url='+ $zeibaurl  + c6Href1);
}
$('.label').children('a').eq(0).addClass('active');
$('.label').children('a').attr('href','javascript:void(0);');
//$('.pleft').children('.xsnew').eq(0).css({'margin-right':'-1px'});
$('.label a').hover(function(){
	var _index = $(this).attr('_for');
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
	$(this).parents('.light').siblings('dd').hide();
	$(this).parents('.light').siblings('#' + _index).show();
})

$('.e1,.d6').children('li').children('a').append('<span class="sparkSpan">斯帕克影视</span>');
</script>