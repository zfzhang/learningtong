<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>用户权限</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
        <link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/validstyle.css" />
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
        <script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
	</head>

	<body>
		<div class="all">
			<div class="main" id="main">
				<div class="header" id="header">
					<?php echo $html_head_content?>
				</div>
				<div class="content">
					<div class="sidebar" id="sidebar">
						<?php echo $html_left_content?>
					</div>
					<div class="content-box">
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active">人员权限</a>
							</div>
							<div class="accountSettings-box">
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>user/save/" class="registerform">
							
							<ul>
								<li style="width:100%">
									<span class="m-name">
										用户名：
									</span>
									<input type="text" style="width: 477px;" name="username" id="username" datatype="s6-18" errormsg="用户名至少6个字符,最多18个字符！" />
								</li>
								<li style="width:100%">
									<span class="m-name">
										名称：
									</span>
									<input type="text" style="width: 477px;" name="realname" id="realname" datatype="zh2-4"errormsg="请填写2-4个中文字的中文名！"/>
								</li>
								<li style="width:100%">
									<span class="m-name">
										说明：
									</span>
									<input type="text" style="width: 477px;" name="remark" id="remark" datatype="*"/>
								</li>
								<li style="width:590px;line-height: 35px;">
									<span class="m-name">
										权限：
									</span>
									
									<div style="width: 485px;float: left;background: #fff;">
									
										<?php 
										$first = true;
										foreach ($actions as $k => $v) {
											if ( is_string($v)) {
												if ( $first ) {
													$first = false;
													echo '<div class="checkbox-box" style="width: 485px;float: left;">';
												} else {
													echo '</div><div class="checkbox-box" style="width: 485px;float: left;">';
												}
												echo '<span class="m-name" style="background: none;border: 0;">';
												echo $v,'：';
												echo '</span>';
												continue;
											}
											
											if ( !$v['show'] ) {
												continue;
											}
											
											echo '<input type="checkbox" style="width: 15px;margin-left: 10px;" name="user_rights[]" value="',$k,'" />';
											echo '<span style="float: left;margin-left: 5px;">',$v['desc'],'</span>';
											
										}
										echo '</div>';
										?>
									
									</div>
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码：
									</span>
									<input type="password" style="width: 477px;" name="userpassword" id="password"  datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"/>
								</li>
								<li style="width:100%">
									<span class="m-name">
										密码确认：
									</span>
									<input type="password" style="width: 477px;" name="userpassword2" id="confirm"  recheck="userpassword" datatype="*" nullmsg="请再输入一次密码！" errormsg="您两次输入的账号密码不一致！" />
								</li>
							</ul>
							
							</form>
							
						</div>
						<div class="btn-box" style="float: left;height: 50px;"  >
								<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">添加</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript" charset="utf-8">
$(function(){
	/*
	$('input[type=checkbox]').each(function(){
		$(this).attr('checked', true);
	});
	*/
	$('input[type=checkbox]').click(function () {
		if ( $(this).attr('checked') ) {
			$(this).attr('checked', false);
		} else {
			$(this).attr('checked', true);
		}
	});
});
</script>
<script type="text/javascript">
$(function(){
	//$(".registerform").Validform();  //就这一行代码！;
	var demo=$(".registerform").Validform({
		tiptype:3,
		label:".label",
		showAllError:true,
		datatype:{
			"zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/
		},

	});
	
	//通过$.Tipmsg扩展默认提示信息;
	//$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
})
</script>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>