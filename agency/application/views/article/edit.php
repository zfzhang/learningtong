<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>编辑分享</title>
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
						<form class="registerform" method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>article/save/">
						<input type="hidden" name="id" value="<?php echo $item['id']?>" >
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>article/list/" >知识分享</a>
								<a class="active" href="#">编辑分享</a>
							</div>
							<div class="input-box">
								<span>标题：</span>
								<input type="text"  datatype="*5-40" nullmsg="请输入标题" errormsg="请输入5-40个字的标题！"  name="title" id="title" value="<?php echo $item['title']?>" />
							</div>
							<div class="input-box">
								<span>摘要：</span><input type="text"  datatype="*15-60" name="remark" id="remark"  value="<?php echo $item['remark']?>" />
							</div>
							<div class="input-box">
								<span>来源：</span>
								<input datatype="*" type="text" name="from"  id="from"  value="<?php echo $item['src']?>" />
							</div>
							<div class="table-cell">
								<textarea name="content" class="<?php echo $xheditor_config?>" name="content" id="content"><?php echo $item['content']?></textarea>
							</div>
							<div class="btn-box">
								<button id="btnSubmit">确定提交</button>
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