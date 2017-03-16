reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
function emails(email,eErrHtml,eErrCss){
	if (email != "") {
		isok= reg.test(email );
		if (!isok) {
			eErrHtml.html('您输入的邮箱格式不正确');//您输入的邮箱格式不正确
			eErrCss.addClass("error");
		}else{
			eErrCss.removeClass("error");
			eErrHtml.html("");
			return true;
		}
	}else{
		eErrHtml.html('请输入您的邮箱');//请输入您的邮箱
		eErrCss.addClass("error");
	}
	return false;
}
function password(password,pErrCss){
	if(password.length < 6){
		$('.passLen').addClass("error");
		pErrCss.addClass("error");
	}
}
function logPassword(pErrHtml,pErrCss){
	pErrHtml.text('请输入您的密码');//请输入您的密码 
	pErrCss.addClass("error");
}
//CharMode函数
//测试某个字符是属于哪一类.
function CharMode(iN) {
	if (iN >= 48 && iN <= 57)//数字
		return 1;
	if (iN >= 65 && iN <= 90)//大写字母
		return 2;
	if (iN >= 97 && iN <= 122)//小写
		return 4;
	else
		return 8;
	//特殊字符
}

//bitTotal函数
//计算出当前密码当中一共有多少种模式
function bitTotal(num) {
	modes = 0;
	for ( i = 0; i < 4; i++) {
		if (num & 1)
			modes++;
		num >>>= 1;
	}
	return modes;
}
//checkStrong函数
//返回密码的强度级别
function checkStrong(sPW) {
	if (sPW.length <= 5)
		return 0;
	//密码太短
	Modes = 0;
	for ( i = 0; i < sPW.length; i++) {
		//测试每一个字符的类别并统计一共有多少种模式.
		Modes |= CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}
function passHeight(pwd){
	O_color = "#efefef";
	L_color = "#8ec473";
	M_color = "#8ec473";
	H_color = "#8ec473";
	if (pwd == null || pwd == '') {
		Lcolor = Mcolor = Hcolor = O_color;
	} else {
		S_level = checkStrong(pwd);
		switch(S_level) {
			case 0:
				Lcolor = Mcolor = Hcolor = O_color;
			case 1:
				Lcolor = L_color;
				Mcolor = Hcolor = O_color;
				break;
			case 2:
				Lcolor = Mcolor = M_color;
				Hcolor = O_color;
				break;
			default:
				Lcolor = Mcolor = Hcolor = H_color;
		}
	}
	$('.passLow').css({"background-color":Lcolor})
	$('.passMedium').css({"background-color":Mcolor})
	$('.passHigh').css({"background-color":Hcolor})
}
function passwordAg(password,passworda,paErrHtml,paErrCss){
	if(passworda != password){
		paErrHtml.html("Enter the same password as above!");//必须一致s 
		paErrCss.addClass("error");
	}
}
function codes(password,paErrHtml,paErrCss){
	if(password == ''){
		paErrHtml.text("captcha is require!");
		paErrCss.addClass("error");
	}
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
function strFun(fn) {
    var Fn = Function;  //一个变量指向Function，防止有些前端编译工具报错
    return new Fn('return ' + fn)();
}

$(function(){
	$("#login").click(function(){
		var email = $('input[name="user"]').val();
		var pw = $('input[name="pass"]').val();
		$.ajax({
			type : 'post',
			url : 'index.php?r=vipspark/login',
			data : {email:email,pw:pw},
			dataType : 'json',
			success : function(result){
				if(result.status==1){
					window.location = getCookie('LOGNURL');
				}else if(result.status==0){
					$('input[name="pass"]').siblings(".help-block").text("用户名或密码不正确");
					$('.controls').addClass('error');
				}
			}
		})
	})
	$(".controls input").focus(function(){
		$('.help-block').text("");
		$('.controls').removeClass('error');
	})
	$(".buttonmess").click(function(){
		var title = $("input[name='title']").val();
		var con = $(".inputCon").val();
		$.ajax({
			type : 'post',
			url : 'index.php?r=vipspark/insert',
			data : {title:title,con:con},
			dataType : 'json',
			success : function(result){
				if(result.status == 1){
					window.location=window.location.href;
				}
				if(result.status == 2){
					$('.red').text(result.message);
				}
			}
		})
	})
	$('.delete').click(function(){
		var dataId = $(this).attr('dataId');
		$.ajax({
			type : 'post',
			url : 'index.php?r=vipspark/delete',
			data : {dataId:dataId},
			dataType : 'json',
			success : function(result){
				if(result.status == 1){
					window.location=window.location.href;
				}
			}
		})
	})
	$('.inputButtCon').click(function(){
		var dataId = $(this).attr("dataId");
		var con = $(".inputCon").val();
		$.ajax({
			type : 'post',
			url : 'index.php?r=vipspark/insertcon',
			data : {dataId:dataId,con:con},
			dataType : 'json',
			success : function(result){
				if(result.status == 1){
					window.location=window.location.href;
				}
			}
		})
	})
})
///===========================注册页面===============================
$(function(){
	
	$("#register_email").blur(function(){
		var val = $(this).val();
		var ErrHtml = $(this).next(".help-block");
		var ErrCss = $(this).parents(".controls");
		emails(val,ErrHtml,ErrCss);
	})
	$("#register_password").blur(function(){
		var pw = $(this).val();
		var pErrHtml = $(this).next(".help-block");
		var pErrCss = $(this).parents(".controls");
		passHeight(pw);
		password(pw,pErrHtml,pErrCss)
	})
	$("#register_password").keyup(function(){
		var pwd = $(this).val();
		passHeight(pwd);
	})
	$("#register_passwordAgain").blur(function(){
		var pw = $(this).val();
		var pwa = $("#register_password").val();
		var paErrHtml = $(this).next(".help-block");
		var paErrCss = $(this).parents(".controls");
		passwordAg(pw,pwa,paErrHtml,paErrCss);
	})
	$(".codeInput").blur(function(){
		var pw = $(this).val();
		var paErrHtml = $(this).siblings(".help-block");
		var paErrCss = $(this).parents(".controls");
		codes(pw,paErrHtml,paErrCss);
	})
	$("#register_password,#register_email,#register_passwordAgain,.codeInput").focus(function(){
		$(this).siblings(".help-block").text("");
		$(this).parents(".controls").removeClass("error");
		$("#error").text("");
	})
	$("#register_password").focus(function(){
		$('.passLen').removeClass("error");
	})
	$("#createAccount").click(function(){
		var logins = $(".registerWarp");
		var emailKey = logins.find('#register_email');
		var passKey = logins.find('#register_password');
		var passKeyA = logins.find('#register_passwordAgain');
		var email = emailKey.val();
		var pass = passKey.val();
		var passworda = passKeyA.val();
		var code = $("input[name='code']").val();
		var eErrHtml = emailKey.next(".help-block");
		var eErrCss = emailKey.parents(".controls");
		var pErrHtml = passKey.next(".help-block");
		var pErrCss = passKey.parents(".controls");
		var paErrHtml = passKeyA.next(".help-block");
		var paErrCss = passKeyA.parents(".controls");
		var codeT = $("input[name='code']").siblings(".help-block");
		var codeC = $("input[name='code']").parents(".controls");
		$('input[type=text],input[type=password]').each(function(){
			if($(this).val()==''){
				$(this).siblings('.help-block').text("不能为空");
				$(this).parents('.controls').addClass('error');
			}
		})
		if($('.error').size()==0){
			$.ajax({
				type : 'post',
				url : 'index.php?r=vipspark/insterreg',
				data : {email:email,pass:pass,passworda:passworda,code:code},
				dataType : 'json',
				success : function(result){
					if(result.status==1){
						location.href = "index.php?r=vipspark/sin";
					}else if(result.status==2){
						eErrHtml.text(result.message);
						eErrCss.addClass('error');
					}else{
						emails(email,eErrHtml,eErrCss);
						password(pass,pErrCss);
						passwordAg(pass,passworda,paErrHtml,paErrCss);
						codes(code,codeT,codeC);
						if($('.error').length==0){
							$('#error').css({'display':'inline-block'});
							$('#error').text(result.errorMessage);
						}
					}
				}
			})
		}
	})
})
