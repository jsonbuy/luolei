<?php
     $email = $_GET['email'];
	 $pw = urldecode($_GET['pw']);
	 var_dump($email,$pw);
	 exit;
	 $json_str=array(array('ret'=>1,'data'=>'test'));
	 $json_str=json_encode($json_str);
	  // $json_str='[{"name":"li","sex":"man"},{"name":"xu","age":38}]';
	   echo $json_str;
  //$arr=array("name"=>"xiaohong", "age"=>20);
  //print 'var data = ' . json_encode($arr);
  
?>