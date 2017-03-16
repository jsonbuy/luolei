define(['jquery'],function ($) {
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }
    function getCookie(c_name)
    {
        if (document.cookie.length>0)
          {
          c_start=document.cookie.indexOf(c_name + "=")
          if (c_start!=-1)
            { 
            c_start=c_start + c_name.length+1 
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) c_end=document.cookie.length
            return unescape(document.cookie.substring(c_start,c_end))
            } 
          }
        return ""
    }
    function setCookie(c_name,value,expiredays)
    {
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
    }
    function delCookie(name)
    {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    }
    function evens(){
        $('.signClick').click(function(){
            setCookie('LOGNURL',window.location.href,360);
            window.location.href = 'index.php?r=vipspark/sin';
        })
    }
    return {
        evens      : evens,
        setCookie  : setCookie,
        getCookie  : getCookie,
        delCookie  : delCookie
    }
})