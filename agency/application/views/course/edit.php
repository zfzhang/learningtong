<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>课程介绍</title>
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
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor.js"></script>
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/xheditor_lang/zh-cn.js"></script>
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
					
						<form class="registerform" method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>course/save/">
						<input type="hidden" name="id" value="<?php echo $item['id']?>">
						<input type="hidden" name="class_id" value="<?php echo $item['class_id']?>">
						<div class="content-inner">
							<div class="navbar-top">
								<a class="active">编辑班别</a>
							</div>
							<ul>
								<li>
									<div class="con-name">
										班别名称：
									</div>
									<div class="con-info">
										<input datatype="*2-10" nullmsg="请输入班别名称！" errormsg="请输入2-16个字！" type="text" name="name" id="name" value="<?php echo $item['name']?>" />
									</div>
								</li>
								<li style="height:90px">
									<div class="con-name">
										课程内容：
									</div>
									<div class="con-info">
										<textarea datatype="*" nullmsg="请输入课程内容" name="content" id="content" style="width: 302px;resize: none;" rows="6"><?php echo $item['content']?></textarea>
									</div>
								</li>
								<li>
									<div class="con-name">
										上课时间：
									</div>
									<div class="con-info">
										<input datatype="*" nullmsg="请输入上课时间" type="text" name="time" id="time" value="<?php echo $item['time']?>" />
									</div>
								</li>
								<li>
									<div class="con-name">
										课时：
									</div>
									<div class="con-info">
										<input datatype="*" nullmsg="请输入课时" type="text" name="hours" id="hours" value="<?php echo $item['hours']?>" />
									</div>
								</li>
								<li>
									<div class="con-name">
										学费：
									</div>
									<div class="con-info">
										<input datatype="*" nullmsg="请输入学费" type="text" name="tuition" id="tuition" value="<?php echo $item['tuition']?>" />
									</div>
								</li>
								<li>
									<div class="con-name">
										招生人数：
									</div>
									<div class="con-info">
										<input datatype="*" nullmsg="请输入招生人数" type="text" name="num" id="num" value="<?php echo $item['num']?>" />
									</div>
								</li>
							</ul>
							<div class="btn-box">
								<button id="btnSubmit" style="margin-left: 10%;margin-top: 50px;float: left;">确定提交</button>
							</div>
						</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8">
$(function(){	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
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
	});
	
	//通过$.Tipmsg扩展默认提示信息;
	//$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
})
</script>