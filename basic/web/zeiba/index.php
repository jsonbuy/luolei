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
li{display:inline-block;}
.zeibaList{margin-top:20px;}
.zeibaList .img{width:96px;height:131px;float:left;border:1px solid #ccc;padding:2px;position:relative;display:block;}
.zeibaList .img span{width:100%;height:25px;line-height:24px;position:absolute;left:0px;bottom:0px;background-color:#ef3f22;z-index:9;color:white;text-align:center;}
.zeibaList .txtBox{margin-left:100px;width:auto;}
.zeibaList .txtBox p{margin-top:10px;}
.zeibaList .txtBox .add{color:#046DB5;font-size:13px;}
.zeibaList .txtBox .add small{margin-right:10px;display:inline-block;}
.zeibaList .txtBox .pingfen small{font-size: 16px;margin-right:25px;font-weight:bold;}
.zeibaList .txtBox .pingfen .db{font-size: 13px;font-weight: normal;color: #FFFFFF;padding: 4px;background: #259235; margin-right: 7px;margin-bottom:5px;display:inline-block;}
.zeibaList .txtBox .pingfen .imdb{font-size: 13px;font-weight: normal;color: #FFFFFF;padding: 4px;background: #1FBEE8; margin-right: 7px;margin-bottom:5px;display:inline-block;}
.zeibaList .txtBox .title{color:#046DB5;font-size:14px;font-weight:bold;}
.zeibaList .content{max-height:50px;overflow:hidden;}
.pagelist{margin-top:20px;}
.pagelist li{margin-bottom:8px;}
.pagelist li a{padding:5px;}
.pagelist li a:hover{background-color:#1FBEE8;color:white;}
.pagelist li.thisclass{color:red;}
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
		$url = $zeibaurl."/txt/25/list_141_1.html";
	}
	if(gzdecode(file_get_contents($url))){
		$content = gzdecode(file_get_contents($url));
	}else{
		$content = file_get_contents($url);
	}
	$con = mb_convert_encoding($content, 'utf-8', 'gbk');
	$preg = "#<div class=\"listbox\".*?>.*?<div class=\"pright2\">#ism";
	preg_match_all($preg, $con,$arr);
?>
<div class="dy2018">
	<ul class="lineBlock dyCon">
	<?php
		foreach ($arr as $key =>$value) {
			$var =  $value[0];
			$preg = "#<div class=\"img\"><a href='(.*)'>(.*)<\/div>.*<a href=\"(.*)\".*>(.*)<\/a>.*<p class=\"intro\">(.*)<\/p>.*<span class=\"add\">(.*)<\/span>.*<p class=\"pingfen\">(.*)<\/p>#iUs";
			
			preg_match_all($preg, $var , $arrs);
			foreach ($arrs[2] as $keys => $values) {
	?>
		<li class="zeibaList">
			<a class="img" href="zeibaList.php?url=<?php echo $zeibaurl.$arrs[1][$keys]; ?>" target="_blank">
				<span>斯帕克影视</span>
			<?php
				echo $values;
			?>
			</a>
			<div class="txtBox">
				<a class="title" href="zeibaList.php?url=<?php echo $zeibaurl.$arrs[1][$keys]; ?>" target="_blank">
				<?php
					echo $arrs[4][$keys];
				?>
				</a>
				<?php
					echo '<p class="content">'.$arrs[5][$keys].'</p>';
					echo '<p class="add">'.$arrs[6][$keys].'</p>';
					echo '<p class="pingfen">'.$arrs[7][$keys].'</p>';
				?>
			</div>
		</li>
	<?php
			}
		}
	?>
	</ul>
	<?php
		foreach ($arr as $key =>$value) {
			$var =  $value[0];
			$pregPage = "#<ul class=\"pagelist\">(.*)<\/ul>#iUs";
			preg_match_all($pregPage, $var , $arrPage);
			foreach ($arrPage[0] as $keys => $values) {
				echo $values;
			}
		}
	?>
	
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
	pageLI.attr('href' , 'index.php?url='+ $zeibaurl +'/txt/25/' + pageHref);
}
</script>
