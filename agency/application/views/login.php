<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>管理员登录</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/reset.css"/>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/structure.css"/>
	</head>
	<body>
		<div class="box info" style="background:url(<?PHP echo URL::base()?>img/login_pic.jpg)">
		</div>
        <div class="box login">
            <fieldset class="boxBody">
              <label style="font-weight:bold;">企业账号</label>
              <input type="text" tabindex="1" placeholder="输入您所在机构的账号" id="agency_sid" required>
              <label style="font-weight:bold;">用户名</label>
              <input type="text" tabindex="2" placeholder="输入您的用户名" id="username" required>
              <label style="font-weight:bold;"><a href="#" class="rLink" tabindex="5">忘记密码?</a>密码</label>
              <input type="password" tabindex="3" required  id="password">
            </fieldset>
            <footer>
              <input type="submit" class="btnLogin" value="登陆" tabindex="4" id="btnLogin" href="#">
            </footer>
        </div>
        <footer id="main">
  		Copyright&copy;2006-2014 学信通
		</footer>
	</body>
</html>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery.md5.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnLogin').click(function(){
		var agency_sid = $('#agency_sid').val();
		var username   = $('#username').val();
		var password   = $('#password').val();
		
		password = $.md5(password);
		var url = '<?php echo URL::base(NULL, TRUE)?>session/start/';
		$.post(url, {agency_sid:agency_sid,username:username, password:password}, function(data){
			var json = eval( '(' + data + ')' );
			if ( json.ret != 0 ) {
				alert(json.msg);
			} else {
				window.location.href = json.url;
			}
		});
	});
});
</script>
