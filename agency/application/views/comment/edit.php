<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>老师评语</title>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/ago.css" />
        <link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/validstyle.css" />
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
		<!--[if gte IE 9]>
		  <style type="text/css">
		    .gradient {
		       filter: none;
		    }
		  </style>
		<![endif]-->
        <script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
        <script type="text/javascript" src="<?php echo URL::base()?>laydate/laydate.js"></script>
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
								<a href="<?php echo URL::base(NULL, TRUE)?>comment/list/">老师评语</a>
								<a class="active">编辑评语</a>
							</div>
							
							<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>comment/save/" class="registerform">
							<input type="hidden" name="id" value="<?php echo $item['id']?>"  datatype="*"/>
							
							<div class="accountSettings-box">
								<ul>
									<li>
										<span class="m-name">
											姓名：
										</span>
										<input type="text" readonly="readonly"  id="student" value="<?php echo $item['student']?>" datatype="*">
										<input type="hidden" name="student_id" id="student_id" value="<?php echo $item['student_id']?>">
									</li>
									<li>
										<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>
									</li>
									<li style="width:100%">
										<span class="m-name">
											时间：
										</span>
										<input id="begin_t" name="begin_str"  class="laydate-icon" value="<?php echo $item['begin_str']?>"  datatype="*"/>
										<label style="width:40px; text-align:center; float:left; line-height:35px;">至</label>
										<input id="end_t" name="end_str"  class="laydate-icon" value="<?php echo $item['end_str']?>"  datatype="*"/>
									</li>
									<li style="width: 100%;height: 100px;">
										<span class="m-name">
											评语：
										</span>
										<textarea name="content" id="content" style="width: 477px;resize: none;" rows="6" datatype="*"><?php echo $item['content']?></textarea>
									</li>
								</ul>
							</div>
							
							</form>
							
							<div class="btn-box" style="float: left;height: 50px;"  >
								<button id="btnSubmit" style="margin-top: 10px;margin-left: 100px;">发布</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-popover" style="font-size:0.8em;" id="cntSelector"></div>
		<div class="theme-popover-mask"></div> 
		
	</body>

</html>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
		document.getElementById("sidebar").style.minHeight = document.getElementById("main").clientHeight - document.getElementById("header").clientHeight - 3 + 'px';
	}
</script>
<script type="text/javascript" charset="utf-8">
$(function(){
	var search_url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	var add_url    = window.location.href;
	
	$('.search-field').change(function () {
		var jsonObj = {};
		$('.search-field').each(function(){
			var key = $(this).attr('id');
			var val  = $(this).val();
			jsonObj[key] = val;
		});
		
		$.post(search_url, jsonObj, function (jsonStr) {
			var students = jQuery.parseJSON(jsonStr);
			
			var studentSelector = $('#student');
			studentSelector.empty();
			$.each(students, function (k, v) {
				studentSelector.append('<option value="' + v.id + '">' + v.realname + ' (' + v.birthday + ')' + '</option>');
			});
		});
	});
	
	$('#btnSubmit').click(function () {
		$('#data-form').submit();
	});
	
	$('#btnOpenSelector').click(function(){
		var url = '<?php echo URL::base(NULL, TRUE)?>student/select/?size=4';
		$.get(url, {}, function (html) {
			$('#cntSelector').html(html);
			$('.theme-popover-mask').fadeIn(100);
			$('.theme-popover').slideDown(200);
		});
	});
});

function select_for_audit(student_id) {
	$('#student_id').val(student_id);
	var url = '<?php echo URL::base(NULL, TRUE)?>student/search/';
	$.post(url, {student_id:student_id}, function (jsonStr) {
		var students = jQuery.parseJSON(jsonStr);
		$.each(students, function (k, v) {
			$('#student').val(v.realname + ' (' + v.birthday + ')');
			$('#student_id').val(v.id);
		});
		$('#cntSelector').hide();
	});
}
</script>
<script>
var begin_t = {
    elem: '#begin_t',
    format: 'YYYY/MM/DD',
    min: laydate.now(), //设定最小日期为当前日期
    max: '2099-06-16', //最大日期
    istime: true,
    istoday: false,
    choose: function(datas){
         end_t.min = datas; //开始日选好后，重置结束日的最小日期
         end_t.begin_t = datas //将结束日的初始值设定为开始日
    }
};
var end_t = {
    elem: '#end_t',
    format: 'YYYY/MM/DD',
    min: '2009-06-16',
    max: '2099-06-16',
    istime: true,
    istoday: false,
    choose: function(datas){
        begin_t.max = datas; //结束日选好后，重置开始日的最大日期
    }
};
laydate(begin_t);
laydate(end_t);
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