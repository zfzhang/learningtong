<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>学生查询</title>
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
		<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>laydate/laydate.js"></script>
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
					
					<div class="content-box" style="overflow-x:hidden;">
						<form method="post" class="registerform" id="data-form" action="<?php echo URL::base(NULL, true)?>student/save/">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">在校学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/?signup=adult">成人学员</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>guest/list/">申请查询</a>
								<a class="active" href="#">添加学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/?adult=1">添加成人学员</a>
							</div>
                            <div class="accountSettings-box">
                                 <ul>
                                    <li>
                                        <span class="m-name">姓名：</span>
                                        <input  id="realname" type="text" value="" name="realname" class="inputxt" datatype="zh2-4" />
                                    </li>
                                     <li>
                                        <span class="m-name">性别：</span>
										<input style="width:15px; float:left; margin-left:10px;" name="sex" type="radio" id="sex" value="1" checked/><label for="male">男</label> <input style="width:15px; float:left; margin-left:10px;" class="radioinput" type="radio" value="0" name="sex" id="sex"/><label for="female">女</label>
                                    </li>
                                    <li>
                                        <span class="m-name">出生年月：</span>
                                        <input  id="birthday" name="birthday" type="text" value="" class="laydate-icon inputtxt" datatype="*" nullmsg="请选择您的出生日期！" errormsg="请选择您的出生日期！" />
                                    </li>
                                    <li>
                                        <span class="m-name">所属分机构：</span>
                                        <select name="entity_id" id="entity">
											<option value="">请选择</option>
											<?php foreach ( $entities as $v ) : ?>
											<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
											<?php endforeach?>
										</select>
                                    </li>
                                    <li>
                                        <span class="m-name">所在学校：</span>
                                        <select name="school_id" id="school" datatype="*">
											<option value="">请选择</option>
											<?php foreach ( $schools as $v ) : ?>
											<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
											<?php endforeach?>
										</select>
                                    </li>
                                    <li>
                                        <span class="m-name">所在年级：</span>
                                        <select name="grade_id" id="grade" datatype="*">
											<option value="">请选择</option>
											<?php foreach ( $grades as $v ) : ?>
											<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
											<?php endforeach?>
										</select>
                                    </li>
                                    <li>
                                        <span class="m-name">手机号码：</span>
                                        <input  id="mobile" type="text" name="mobile" class="inputxt" datatype="m" ignore="ignore"  errormsg="请输入正确的手机号码！"  />
                                    </li>
                                    <li>
                                        <span class="m-name">父亲姓名：</span>
                                        <input  id="father_name" type="text" value="" name="father_name" class="inputxt" datatype="zh2-4" />
                                    </li>
                                    <li>
                                        <span class="m-name">父亲手机：</span>
                                        <input  id="father_mobile" type="text" name="father_mobile" class="inputxt" datatype="m" errormsg="请输入正确的手机号码！"   />
                                    </li>
                                    <li>
                                        <span class="m-name">母亲姓名：</span>
                                        <input  id="mother_name" type="text" value="" name="mother_name" class="inputxt" datatype="zh2-4" />
                                    </li>
                                    <li>
                                        <span class="m-name">母亲手机：</span>
                                        <input  id="mother_mobile" type="text" name="mother_mobile" class="inputxt" datatype="m" errormsg="请输入正确的手机号码！"   />
                                    </li>
                                    <li>
                                        <span class="m-name">
										所在区域：
										</span>
                                        <select class="select" id="s1" datatype="*">
											<option value="">请选择省份</option>
										</select>
										<select class="select" id="s2" datatype="*">
											<option value="">请选择城市</option>
										</select>
										<select class="select" id="s3" datatype="*">
											<option value="">请选择地区</option>
										</select>
										<input type="hidden" name="province" id="province" value="0" />
										<input type="hidden" name="city"     id="city" value="0" />
										<input type="hidden" name="area"     id="area" value="0" />
                                    </li>
                                    <li>
                                        <span class="m-name">
										家庭住址：
										</span>
                                        <input  id="addr" type="text" value="" name="addr" class="inputxt" datatype="*" style="width:477px;"/>
                                    </li>
                                    <li>
                                        <span class="m-name">
										报名班别：
										</span>
                                        <div style="background:#dddddd; width:600px; padding:10px;border:1px dashed #a5a5a5;float:left;">
										<?php foreach ( $courses as $v ) : ?>
										<input type="checkbox" class="course course_<?php echo $v['id']?>" style="width: 15px;margin-left: 10px;" name="course[]" value="<?php echo $v['id']?>" datatype="*" />
										<lable style="margin-left: 5px; margin-right:15px; line-height: 30px; float:left;" class="course course_<?php echo $v['id']?>">
											<?php echo $v['name']?>
										</lable>
										<?php endforeach?>
                                        </div>
                                    </li>
									<li>
                                        <span class="m-name">
										特别说明：
										</span>
                                        <textarea rows="9" style="width: 477px;" name="remark" id="remark"></textarea>
                                    </li>
                                 </ul>
                            </div>
							<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button id="btnSubmit" style="margin-left: 105px;margin-top: 10px;">确定添加</button>
							</div>
						</div>
                        </form>
						<div class="btn-box" style="float: left;margin-top: 30px;height: 50px;margin-left: 105px;"  >
								注：添加后不能删除，只能停用。
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
<script type="text/javascript">
$(function(){
	setup();preselect_ex(0,0,0);
	
	//$(".registerform").Validform();  //就这一行代码！;
	var obj = {};
	obj['tiptype'] = 3;
	obj['label']   = '.label';
	obj['showAllError'] = true;
	obj['datatype'] = {};
	obj['datatype']['zh1-6'] = /^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/;
	var demo = $(".registerform").Validform(obj);
	
	//通过$.Tipmsg扩展默认提示信息;
	//$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
	
	$('#btnSubmit').click(function(){
		$('#area').val($('#s3').get(0).selectedIndex);
		$('#data-form').submit();
	});
	
	$('#entity').change(function () {
		var url = '<?php echo URL::base(NULL, TRUE)?>entity/courses/?id=' + $(this).val();
		$.get(url,{},function (jsonStr) {
			var jsonObj = $.parseJSON(jsonStr);
			$('.course').hide();
			$.each(jsonObj, function (i, n) {
				$('.course_' + n.id).show();
			});
		});
	});
	
});
</script>
<script>
laydate({
    elem: '#birthday', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
    event: 'focus' //响应事件。如果没有传入event，则按照默认的click
});
</script>