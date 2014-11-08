<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>密码修改</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/passwd.css"/>
	</head>
	<body>
		<div class="header">
			<?php echo $html_head_content?>
		</div>
		<div class="content">
			<div class="contentLeft">
				<?php echo $html_left_content?>
			</div>
			<div class="contentRight">
				<div class="contentHead">
					<a href="#">首页</a><a class="lastc"><span>></span> 密码修改</a>
				</div>
				<div class="contentBoxTitle">
					密码修改
				</div>
				<div class="contentList">
					<ul>
						<!--
						<li>
							<span class="infoName">原用户名：</span><input type="text" />
						</li>
						<li class="odd">
							<span class="infoName">现用户名：</span><input type="text" />
						</li>
						-->
						<li>
							<span class="infoName">新密码：</span><input type="password"   id="pswd1"/>
						</li>
						<li class="odd">
							<span class="infoName">确认密码：</span><input type="password" id="pswd2"/>
						</li>
						
					</ul>
				</div>
				<div class="sendbutton" id="btnChPswd">确认</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery.md5.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnChPswd').click(function () {
		var pswd1 = $('#pswd1').val();
		var pswd2 = $('#pswd2').val();
		if ( pswd1 != pswd2 ) {
			alert('两次输入不一致，请重新输入！');
			return false;
		}
		
		var url = '<?php echo URL::base(NULL, TRUE)?>login/pswd/';
		$.post(url, {pswd1:$.md5(pswd1), pswd2:$.md5(pswd2)}, function (jsonStr) {
			var resultObj = jQuery.parseJSON(jsonStr);
			if ( resultObj.ret != 0 ) {
				alert(resultObj.msg);
				return false;
			}
			
			$('#pswd1').val('');
			$('#pswd2').val('');
			alert('密码修改成功');
		});
	});
});
</script>
