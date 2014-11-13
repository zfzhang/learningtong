<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>简介</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
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
								<a class="active">简介</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>show/list">展示</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>contact">联系</a>
							</div>
                            <div class="explain-box">
								<p>温馨提示：为了在手机页面有更好的展示效果，学信通提醒您在编辑器里不要随意更改图片大小和文字大小，字体颜色可以根据需要修改。</p>
							</div>
							<br /><br />
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>introduction/save/">
							<textarea name="content"  class="<?php echo $xheditor_config?>" name="content" id="content"><?php echo $item['content']?></textarea>
							</form>
							
							<div class="btn-box">
								<button id="btnSubmit">确定提交</button>
							</div>
						</div>
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