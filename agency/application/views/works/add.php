<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>添加作品</title>
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
        <link rel="stylesheet" href="<?PHP echo URL::base()?>css/jquery.windows.css" media="all">
        <script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
		<script src="<?PHP echo URL::base()?>js/jquery.uploadify.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/uploadify.css">
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
								<a href="<?php echo URL::base(NULL, TRUE)?>works/list/">学生作品</a>
								<a class="active">添加作品</a>
							</div>
							<ul>
                            	<li>
                                	<div class="con-name">
									学生姓名：
									</div>
									<div class="con-info">
										<input type="text" id="student" readonly size="10" maxlength="10" datatype="*">
										<a class="btn btn-primary btn-large theme-login" href="javascript:;" id="btnOpenSelector">选择学生</a>
									</div>
                                </li>
                                <li>
                                	<div class="con-name">
									标题：
									</div>
									<div class="con-info"><i>(字数必须在16个字符内)</i>
									<input type="text" id="show_title"  datatype="*"/>
									</div>
                                </li>
                                <li>
                                	<div class="con-name">
									老师点评：
									</div>
									<div class="con-info">
									<textarea cols="50" rows="5" id="show_comment" datatype="*" style="width:477px;"></textarea>
									</div>
                                </li>
                                <li style="height:30xp; line-height:30px; height:30px">图片上传：</li>
								<li style="background:#dddddd; width:500px; padding:10px;border:1px dashed #a5a5a5; margin-top:-30px; margin-left:80px;">

									<form>
										<div id="queue"></div>
										<input id="file_upload" name="file_upload" type="file" multiple><a href="#" id="btnRmImg">删除</a>
									</form>
									<div id="img_container" style="float:left;width:100%"></div>
								</li>
								
								<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>works/save/"  class="registerform">
								<input type="hidden" name="student_id" id="student_id">
								<input type="hidden" name="img"     id="img_url" value=""/>
								<input type="hidden" name="title"   id="title"   value=""/>
								<input type="hidden" name="comment" id="comment" value="" />
								
								<li>
									<div class="con-name">
										轮播图片：
									</div>
									<div class="con-info">
										<input name="show_type"  type="checkbox" value="1" style="width:20px; height:20px; margin-top:5px; line-height: 20px; float: left; display: block;">
									</div>
								</li>
                                <li>
                                	<div class="table-cell">
									<textarea name="content" class="data-field <?php echo $xheditor_config?>" id="content"></textarea>
									</div>
                                </li>
								</form>
						
                                <li>
                                	<div class="btn-box">
										<button id="btnSubmit">确定提交</button><br/>
									</div>
                                </li>
                            </ul>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		<div class="theme-popover" style="font-size:0.8em;" id="cntSelector"></div>
		<div class="theme-popover-mask"></div> 
		<script type="text/javascript">
		<?php $timestamp = time();?>
		$(function() {
			var upload_dir = '<?php echo $upload_dir?>';
			var base_url = '<?php echo URL::base("http", false)?>';
			
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5("unique_salt" . $timestamp);?>'
				},
				'swf'      : '<?PHP echo URL::base()?>swf/uploadify.swf',
				'uploader' : '<?PHP echo URL::base()?>uploadify.php?sid=<?php echo $session_id?>',
				'onUploadSuccess' : function(file, data, response) {
					var img = base_url + upload_dir + '/' + file.name;
					$('#img_container').html('<img src="' + img + '" width="150">');
					$('#img_url').val(img);
				}
			});
		
			$('#btnSubmit').click(function () {
				$('#title').val($('#show_title').val());
				$('#comment').val($('#show_comment').val());
				$('#data-form').submit();
			});
			
			$('#btnRmImg').click(function () {
				$('#img_container').html('');
				$('#img_url').val('');
			});
		});
		</script>
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
			$('#student').val(v.realname);
			$('#student_id').val(v.id);
		});
		$('#cntSelector').hide();
	});
}
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