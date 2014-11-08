<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>管理员登录</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/login.css"/>
	</head>
	<body>
		<div class="header">
			<div class="headCon">
				<strong>弘翰学信通</strong>
			</div>
		</div>
		<div class="content" id="content" style=" height:auto !important;">
			<div class="login">
				<div class="title">系统登录</div>
				<div class="logininner">
					<ul>
						<li>
							<span class="name">用户名</span>
							<input type="text" id="username" name="username"/>
						</li>
						<li>
							<span class="name">密&nbsp;&nbsp;&nbsp;&nbsp;码</span>
							<input type="password" id="password" name="password"/>
						</li>
					</ul>
				</div>
				<div class="lbutton">
					<a href="javascript:" id="btnLogin">登录</a>
				</div>
			</div>
			<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
		</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery.md5.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	
	$('#btnLogin').click(function(){
		var username = $('#username').val();
		var password = $('#password').val();
		
		password = $.md5(password);
		var url = '<?php echo URL::base(NULL, TRUE)?>session/start';
		$.post(url, {username:username, password:password}, function(data){
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
