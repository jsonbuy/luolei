<script>
function setCookie(c_name, value, expiredays){
var exdate=new Date();
exdate.setDate(exdate.getDate()+ expiredays);
document.cookie=c_name+ "=" + escape(value) + ((expiredays==null) ? "":";expires="+exdate.toGMTString())+";path=/; domain=.ancdone.com";
}
function getCookie(c_name){
  if (document.cookie.length>0){
c_start=document.cookie.indexOf(c_name + "=");
if (c_start!=-1){
c_start=c_start + c_name.length+1;
c_end=document.cookie.indexOf(";",c_start);
if (c_end==-1) c_end=document.cookie.length;
return unescape(document.cookie.substring(c_start,c_end));
}
}
return ""
}

function getURLParameter(name) {
  	return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}
  
function delete_cookie( name ) {
      var exdate=new Date();
      exdate.setDate(exdate.getDate()-2);
  		document.cookie = name + '=; expires='+exdate.toGMTString();
}
  
function checkfrom(furl){
	var fromurl = window.location.href;
	console.log(fromurl,furl,fromurl.indexOf(furl));
  if(fromurl!=null && fromurl.indexOf(furl)>0){
  	return true;  
  }
  return false;
} 
  function setPlatformCookie(utm,cid,source){ 
   		 delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource",source,60);
       setCookie("utm_source",utm,60);
       setCookie("click_id",cid,60);  
  }
  
  
function setStracksCookie(){
   var utm = getURLParameter("utm_source");
   var cid = getURLParameter("click_id");
   var aid = getURLParameter("aid");
  	var source = getURLParameter("source");
   var siteid = getURLParameter("siteID");
   	var clickRef = getURLParameter("cr");
   	var pid = getURLParameter("pid");
   	var tmoki_oid = getURLParameter("oid");
  	 var tmoki_rqid = getURLParameter("rqid");
   // var criteo = getURLParameter("utm_source");
  //utm_source=criteo
    if(siteid==null){
      siteid = getURLParameter("siteid");
    }
 
   // alert(checkfrom('ancdone.com'));
   if(checkfrom('ancdone.com')){
    alert("1111111111");
       delete_cookie("trackssource");
       setCookie("trackssource","ancdone",30);
       delete_cookie("utm_source");
       delete_cookie("click_id");
   }
   /*else if('mopubi.com'==utm || checkfrom('tmoki.com')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","tmoki",30);
       setCookie("tmoki_oid",tmoki_oid,30);
       setCookie("tmoki_rqid",tmoki_rqid,30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if('webgains'==source || checkfrom('webgains.com')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","webgains",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if('Netaffiliation'==utm || checkfrom('metaffiliation.com')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","Netaffiliation",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if('criteo'==utm || checkfrom('criteo.net')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","criteo",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if(utm!=null && cid!=null){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","cityads",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if(checkfrom('linksynergy.com') || (siteid!=null && siteid.length>0)){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","linksynergy",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if(checkfrom('anrdoezrs.net') || checkfrom('dpbolvw.net') ||checkfrom('jdoqocy.com') || checkfrom('kqzyfj.com') || checkfrom('tkqlhce.com')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","cj",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if(checkfrom('clixgalore.com') || checkfrom('clixGalore.com')){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","clixgalore",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
    }else if(checkfrom('admitad.com') || getURLParameter("admitad_uid")!=null){
      	utm = getURLParameter("admitad_uid");
      	cid = getURLParameter("web");
    	 setPlatformCookie(utm,cid,'asbmit');  
    }else if(checkfrom('tradetracker.net')||getURLParameter("utm_source")=="tradetracker"){
       delete_cookie("trackssource");
       delete_cookie("utm_source");
       delete_cookie("click_id");
       setCookie("trackssource","trade",30);
       setCookie("utm_source",utm,30);
       setCookie("click_id",cid,30);
   }else if(aid!=null){
       delete_cookie("utm_source");
       delete_cookie("click_id");
    }*/
      
    if(aid!=null){
      delete_cookie("AID");
      setCookie("AID",aid,15);
    }
    if(clickRef!=null){
      delete_cookie("clickRef");
      setCookie("clickRef",clickRef,15);
    }
    if(pid!=null){
      delete_cookie("pid");
      setCookie("pid",pid,15);
    }
 }
  
function mobvista(){
		var from = getURLParameter("from");
		var uuid = getURLParameter("uuid");
		var clickid = getURLParameter("clickid");
		if(from==='mobvista'){
         delete_cookie("trackssource");
          delete_cookie("uuid");
          delete_cookie("clickid");
         setCookie("trackssource","mobvista",aid,30);
		    setCookie('uuid',uuid,45);
			 setCookie('clickid',clickid,45);
		}
	}
  
mobvista();
setStracksCookie();
  
 </script>