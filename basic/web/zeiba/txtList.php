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

.w960{width:100%;position:relative;}
.pleft2{margin-right:220px;}
.pleft2 .e2 img{width:94px;height:129px;float:left;padding:2px;border:1px solid #ccc;}
.pleft2 .e2 li{height:130px;margin:15px 0px;overflow:hidden;}
.pleft2 .e2 li >dl,.pleft2 .e2 li >span,.pleft2 .e2 li >p{margin-left:105px;display:block;}
.pleft2 .e2 li >dl a{font-size:14px;font-weight:bold;color:#ef3f22;}
.pleft2 .e2 li >span,.pleft2 .e2 li >p{margin-top:5px;}
.pleft2 .e2 li >span small{display:inline-block;color:#06a7e1;margin-right:5px;}

.pleftop{}
.pleftop .etop img{width:94px;height:129px;float:left;padding:2px;border:1px solid #ccc;}
.pleftop .etop li{height:130px;margin:15px 0px;overflow:hidden;width:48%;display:inline-block;margin-right:1%;margin-left:-1px;}
.pleftop .etop li >dl,.pleftop .etop li >span,.pleftop .etop li >p{margin-left:105px;display:block;}
.pleftop .etop li >dl a{font-size:14px;font-weight:bold;color:#ef3f22;}
.pleftop .etop li >span,.pleftop .etop li >p{margin-top:5px;}
.pleftop .etop li >span small{display:inline-block;color:#06a7e1;margin-right:5px;}

.pagelist{margin-top:20px;}
.pagelist li{margin-bottom:8px;display:inline-block;}
.pagelist li a{padding:5px;}
.pagelist li a:hover{background-color:#1FBEE8;color:white;}
.pagelist li.thisclass{color:red;}

.tboxr .c3 {line-height:20px;}
.tboxr dt {margin-top:20px;}
.tboxr .c3 li a{padding:5px;display:block;border-bottom:1px solid #ccc;}

.pright2{width:200px;position:absolute;right:0px;top:0px;}

@media (max-width:768px){
	.pleft2{margin-right:0px;}
	.pright2{position:relative;width:100%;}
}
</style>
<?php
include_once('top.php');
?>
<?php
	if(isset($_GET['url'])){
		$url = $_GET['url'];
		if(strpos($url,".html")){
			$content = file_get_contents($url);
		}else{
			if(gzdecode(file_get_contents($url))){
				$content = gzdecode(file_get_contents($url));
			}else{
				$content = file_get_contents($url);
			}
		}
	}else{
		$url = $zeibaurl."/txt/1/list_95_1.html";
		$content = file_get_contents($url);
	}
	$con = mb_convert_encoding($content, 'utf-8', 'gbk');
	$preg = "#<div class=\"toplantxt\">(.*)<div class=\"flink2\">#ism";
	preg_match_all($preg, $con,$arr);
?>
<div class="dy2018">
<div>
	<?php
		foreach ($arr[0] as $key =>$value) {
			$var =  $value;
			echo $var;
		}
	?>
</div>
<?php
include_once('footer.php');
?>
<script src="js/lib/jquery.js"></script>
<script>
for(var i = 0 , leng = $('.c6').children('li').length; i < leng ; i++){
	if($('.c6').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.c6').children('li').eq(i).children('a').attr('href');
		$('.c6').children('li').eq(i).children('a').attr('href','txtList.php?url='+ $zeibaurl + c6Href);
	}
}
for(var i = 0 , leng = $('.c3').children('li').length; i < leng ; i++){
	if($('.c3').children('li').eq(i).children('a').length == 1){
		var c6Href = $('.c3').children('li').eq(i).children('a').attr('href');
		$('.c3').children('li').eq(i).children('a').attr('href','zeibaList.php?url='+ $zeibaurl + c6Href);
	}
}
for(var i = 0 , leng = $('.e2').children('li').length; i < leng ; i++){
	var c6Href = $('.e2').children('li').eq(i).find('a').eq(0).attr('href');
	var c6Href1 = $('.e2').children('li').eq(i).find('a').eq(1).attr('href');
	$('.e2').children('li').eq(i).find('a').eq(0).attr('href','zeibaList.php?url='+ $zeibaurl + c6Href);
	$('.e2').children('li').eq(i).find('a').eq(1).attr('href','zeibaList.php?url='+ $zeibaurl + c6Href1);
}
for(var i = 0 , leng = $('.etop').children('li').length; i < leng ; i++){
	var c6Href = $('.etop').children('li').eq(i).find('a').eq(0).attr('href');
	var c6Href1 = $('.etop').children('li').eq(i).find('a').eq(1).attr('href');
	$('.etop').children('li').eq(i).find('a').eq(0).attr('href','zeibaList.php?url='+ $zeibaurl + c6Href);
	$('.etop').children('li').eq(i).find('a').eq(1).attr('href','zeibaList.php?url='+ $zeibaurl + c6Href1);
}
$('.e2').children('li').children('.img').children('a').append('<span class="sparkSpan">斯帕克影视</span>');
$('.etop').children('li').children('.img').children('a').append('<span class="sparkSpan">斯帕克影视</span>');
</script>