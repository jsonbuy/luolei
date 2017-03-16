<?php
	// response.setHeader("Access-Control-Allow-Origin", "*");
	 header("Access-Control-Allow-Origin: *");
	// echo header("Access-Control-Allow-Origin:*");
	 //header("Access-Control-Allow-Origin: https://www.linkhaitao.com/api.php?mod=order");
?>
<meta http-equiv="Access-Control-Allow-Origin" content="https://www.linkhaitao.com/api.php?mod=order">
<script type="text/javascript">
  function sends() {
  		var dzb = "c_track=111";
		CreateXMLHttpRequest();
    xmlhttp.onreadystatechange = callhandle;
    //xmlhttp.open("GET","https://www.linkhaitao.com/api.php?mod=order",true);
    xmlhttp.open("POST", "https://www.linkhaitao.com/api.php?mod=order", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");  //用POST的时候一定要有这句
    xmlhttp.send(dzb);
  }
  
  function CreateXMLHttpRequest() {
    if (window.ActiveXObject) {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    }
  }

  function callhandle() {
    if (xmlhttp.readyState == 4) {
      if (xmlhttp.status == 200) {
        alert(xmlhttp.responseText);
      }
	  else{
		  alert('error');
	  }
    }
  }
  sends();
  
</script>

