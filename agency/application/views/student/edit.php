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
		
		<script type="text/javascript" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
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
						<input type="hidden" name="id" value="<?php echo $item['id']?>">
						<div class="content-inner">
							<div class="navbar-top">
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">在校学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/list/?signup=adult">成人学员</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>guest/list/">申请查询</a>
								<a class="active" href="#">编辑学生</a>
								<a href="<?php echo URL::base(NULL, TRUE)?>student/add/?adult=1">添加成人学员</a>
							</div>
                            <div class="accountSettings-box">
                            <ul>
                            	<li>
                                	<span class="m-name">姓名：</span>
                                    <input type="text" name="realname" id="realname" value="<?php echo $item['realname']?>"  class="inputxt" datatype="zh2-4"/>
                                </li>
                                <li>
                                        <span class="m-name">性别：</span>
										<input style="width:15px; float:left; margin-left:10px;" name="sex" type="radio" id="sex" value="1"  <?php if ($item['sex'] == 1) echo 'checked="checked"'?>/><label for="male">男</label> <input type="radio" value="0" <?php if ($item['sex'] == 0) echo 'checked="checked"'?>  name="sex" id="sex" style="width:15px; float:left; margin-left:10px;" /><label for="female">女</label>
                                </li>
                                <li>
                                        <span class="m-name">出生年月：</span>
                                        <input  id="birthday" name="birthday" type="text" class="laydate-icon inputtxt" datatype="*" nullmsg="请选择您的出生日期！" errormsg="请选择您的出生日期！"  value="<?php echo $item['birthday']?>"/>
                                </li>
                                <li>
                                        <span class="m-name">所属分机构：</span>
                                        <select name="entity_id" id="entity">
											<option value=""></option>
											<?php foreach ( $entities as $v ) : ?>
											<option value="<?php echo $v['id']?>" 
												<?php
												if ( $item['entity_id'] == $v['id'] ) {
													echo 'selected="selected"';
												}
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
                                </li>
                                <li>
										<span class="m-name">所在学校：</span>
										<select name="school_id" id="school"  datatype="*">
											<option value=""></option>
											<?php foreach ( $schools as $v ) : ?>
											<option value="<?php echo $v['id']?>" 
												<?php
												if ( $item['school_id'] == $v['id'] )
													echo 'selected="selected"';
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
								</li>
                                <li>
										<span class="m-name">所在年级：</span>
										<select name="grade_id" id="grade"  datatype="*">
											<option value=""></option>
											<?php foreach ( $grades as $v ) : ?>
												<option value="<?php echo $v['id']?>"  
												<?php
												if ( $item['grade_id'] == $v['id'] )
													echo 'selected="selected"';
												?> >
												<?php echo $v['name']?>
											</option>
											<?php endforeach?>
										</select>
								</li>
                                <li>
										<span class="m-name">手机号码：</span>
										<input type="text" name="mobile" id="mobile" value="<?php echo $item['mobile']?>"  datatype="m" ignore="ignore"  errormsg="请输入正确的手机号码！" class="inputxt"/>
									</li>
									<li>
										<span class="m-name">父亲姓名：</span>
										<input type="text" name="father_name" id="father_name" value="<?php echo $item['father_name']?>" class="inputxt" datatype="zh2-4"/>
									</li>
									<li>
										<span class="m-name">父亲手机：</span>
										<input type="text" name="father_mobile" id="father_mobile" value="<?php echo $item['father_mobile']?>" class="inputxt" datatype="m" errormsg="请输入正确的手机号码！"/>
									</li>
									<li>
										<span class="m-name">母亲姓名：</span>
										<input type="text" name="mother_name" id="mother_name" value="<?php echo $item['mother_name']?>" class="inputxt" datatype="zh2-4"/>
									</li>
									<li style="width:100%">
										<span class="m-name">母亲手机：</span>
										<input type="text" name="mother_mobile" id="mother_mobile" value="<?php echo $item['mother_mobile']?>" class="inputxt" datatype="m" errormsg="请输入正确的手机号码！"/>
									</li>
									<li>
										<span class="m-name">
										所在区域：
										</span>
										<select class="select" id="s1">
											<option value="">请选择省份</option>
										</select>
										<select class="select" id="s2">
											<option value="">请选择城市</option>
										</select>
										<select class="select" id="s3">
											<option value="">请选择地区</option>
										</select>
										<input type="hidden" name="province" id="province" value="<?php echo $item["province"]?>" />
										<input type="hidden" name="city" id="city" value="<?php echo $item["city"]?>" />
										<input type="hidden" name="area" id="area" value="<?php echo $item["area"]?>" />
									</li>
									<li>
										 <span class="m-name">
										家庭住址：
										</span>
										<input style="width: 477px !important;" type="text" name="addr" id="addr" value="<?php echo $item['addr']?>" class="inputxt" datatype="*"/>
									</li>
									<li>
										<span class="m-name">
										报名班别：
										</span>
										<div style="background:#dddddd; width:600px; padding:10px;border:1px dashed #a5a5a5;float:left;">
										<?php foreach ( $courses as $v ) : ?>
										<input type="checkbox" class="course course_<?php echo $v['id']?>" style="width: 15px;margin-left: 10px;" name="course[]" value="<?php echo $v['id']?>" datatype="*"
											<?php if ( isset($student_courses[$v['id']]) ) { echo 'checked="checked"'; } ?> />
										<lable style="margin-left: 5px; margin-right:15px; line-height: 30px;float:left;" class="course course_<?php echo $v['id']?>">
											<?php echo $v['name']?>
										</lable>
										<?php endforeach?>
										</div>
									</li>
									<li>
										 <span class="m-name">
										特别说明：
										</span>
										<textarea rows="9" style="width: 477px;" name="remark" id="remark"  datatype="*"><?php echo $item['remark']?></textarea>
									</li>
									<li>
										 <span class="m-name">
										验证码：
										</span>
										<input class="inputxt" type="text" value="<?php echo $code?>" style="color:#F00; font-weight:bold" />
										<a href="<?php echo URL::base(NULL, TRUE),'student/notify/?id=',$item['id']?>" target="_blank">
											重新发送
										</a>
									</li>
                            </ul>
                            </div>
							<div class="btn-box" style="float: left;margin-top: 0px;height: 50px;"  >
								<button id="btnSubmit" style="margin-left: 105px;margin-top: 10px;">确定修改</button>
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

<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript">
$(function(){
	var s1 = '<?php echo $item["province"]?>';
	var s2 = '<?php echo $item["city"]?>';
	var s3 = '<?php echo $item["area"]?>';
	setup();preselect_ex(s1,s2,s3);
	
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