<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>发布作业</title>
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
        <script type="text/javascript" src="<?php echo URL::base()?>laydate/laydate.js"></script>
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
					
						<form class="registerform" method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>task/save/">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>task/list/" >作业任务</a>
								<a class="active" href="#">发布作业</a>
							</div>
                            <ul>
                            	<li>
                                <label class="label"><span class="need">*</span> 日期：</label>
                                <input class="laydate-icon inputxt" name="date_str" id="date"  datatype="*"/>
                                </li>
                                <li>
                                <label class="label"><span class="need">*</span> 分机构：</label>
                                <select name="entity_id" id="class" datatype="*"/>
									<option value=""></option>
									<?php foreach ( $entities as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
									<?php endforeach?>
								</select>
                                </li>
                                <li>
                                <label class="label"><span class="need">*</span> 机构班别：</label>
                                <select name="course_id" id="class" datatype="*">
									<option value=""></option>
									<?php foreach ( $courses as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
									<?php endforeach?>
								</select>
                                </li>
                                 <li>
                                <label class="label"><span class="need">*</span> 所在学校：</label>
                                <select name="school_id" id="school" datatype="*">
									<option value=""></option>
									<?php foreach ( $schools as $v ) : ?>
									<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
									<?php endforeach?>
								</select>
                                </li>
                                 <li>
                                <label class="label"><span class="need">*</span> 所在班级：</label>
                                <select name="grade_id" id="grade" datatype="*">
									<option value=""></option>
									<?php foreach ( $grades as $v ) : ?>
									<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
									<?php endforeach?>
								</select>
                                </li>
                                <li>
                                <label class="label"><span class="need">*</span> 标题：</label>
                                <input type="text" name="title" id="title"  datatype="*" style="width:477px"  class="inputxt" />
                                </li>
                                <li>
                                <textarea name="content" class="<?php echo $xheditor_config?>" id="content"></textarea>
                                </li>
                                <li>
                                <div class="btn-box">
								<button id="btnSubmit">确定发布</button>
								</div>
                                </li>
                            </ul>
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
<script>
laydate({
    elem: '#date', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
    event: 'focus' //响应事件。如果没有传入event，则按照默认的click
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