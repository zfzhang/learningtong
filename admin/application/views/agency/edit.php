<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>开通客户</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/openclient.css"/>
        <link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/validstyle.css" />
        <script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
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
					<a href="#">首页</a><a class="lastc"><span>></span> 开通客户</a>
				</div>
				<div class="contentList">
					<div class="accountSettings">
						<div class="accountSettings-title">
							账号设置
						</div>
						
						<form class="registerform" method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>agency/save/">
						<input type="hidden" name="id" id="id" value="<?php echo $item['id']?>" />
						
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										用户名：
									</span>
									<input name="username" type="text" id="username" value="<?php echo $item['username']?>" readonly />
									<i class="tishi">此用户名为用户ID</i>
							  	</li>
								<li>
									<span class="m-name">
										公众号名称：
									</span>
									<input type="text" name="viewname"  id="viewname" value="<?php echo $item['viewname']?>"  datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										微信号：
									</span>
									<input type="text" name="weixin"    id="weixin"   value="<?php echo $item['weixin']?>" />
                                </li>
								<li>
									<span class="m-name">
										微信原始号：
									</span>
									<input type="text" name="weixin_id" id="weixin_id" value="<?php echo $item['weixin_id']?>" />
								</li>
								<li>
									<span class="m-name">
										公众号appid：
									</span>
									<input type="text" name="wx_appid"  id="wx_appid" value="<?php echo $item['wx_appid']?>"  datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										公众号secret：
									</span>
									<input type="text" name="wx_secret" id="wx_secret" value="<?php echo $item['wx_secret']?>"  datatype="*"/>
								</li>
								<li>
									<span class="m-name">
										公众号类型：
									</span>
									<select name="less_func">
										<option value="0" <?php if ($item['less_func'] == 0) echo 'selected="selected"'?> >服务号<option>
										<option value="1" <?php if ($item['less_func'] == 1) echo 'selected="selected"'?> >定阅号<option>
									</select>
								</li>
							</ul>
						</div>
						<div class="accountSettings-title">
							基本信息设置
						</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										客户名称：
									</span>
									<input type="text" name="realname" id="realname" value="<?php echo $item['realname']?>"  datatype="*"/>
								</li>
								<li>	
									<span class="m-name">
										客户类型：
									</span>
									<select name="client_type" id="client_type" datatype="*">
										<?php foreach ( $client_types as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li> 
									<span class="m-name">
										分机构数：
									</span>
									<input type="text" name="entity_num" id="entity_num" value="<?php echo $item['entity_num']?>"  size="3" maxlength="3"  style="width:40px" datatype="n1-3"/>
								</li>
                                <li>
									<span class="m-name">
										学生人数：
									</span>
									<input type="text" name="student_num" id="student_num" value="<?php echo $item['student_num']?>" size="3" maxlength="3"  style="width:40px" datatype="n1-3"/>
								</li>
                                <li>
									<span class="m-name">
										短信模板：
									</span>
									<input type="text" name="sms_tpl_id" id="sms_tpl_id" value="<?php echo $item['sms_tpl_id']?>" size="4" maxlength="4"  style="width:50px" datatype="n1-4"/>
								</li>
                                <li>
                                	<span class="m-name">
										机构性质：
									</span>
									<select name="agency_type_id" id="agency_type_id" datatype="*">
										<?php foreach ( $agency_types as $v ) : ?>
										<option value="<?php echo $v['id']?>" <?php if ( $v['id'] == $item['agency_type_id'] ) echo 'select="select"'?> >
											<?php echo $v['name']?>
										</option>
										<?php endforeach?>
									</select>
								</li>
								<li>	
									<span class="m-name">
										缴费方案：
									</span>
									<select name="pay_type_id" datatype="*">
										<?php foreach ( $pay_types as $v ) : ?>
										<option value="<?php echo $v['id']?>" <?php if ( $v['id'] == $item['pay_type_id'] ) echo 'select="select"'?> >
											<?php echo $v['name']?>
										</option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">所在地区：</span>
									
									<select id="s1">
										<option value="">请选择省份</option>
									</select>
									
									<select id="s2">
										<option value="">请选择城市</option>
									</select>
									
									<select id="s3">
										<option value="">请选择地区</option>
									</select>
								
									<input type="hidden" name="province" id="province" value="<?php echo $item['province']?>" />
									<input type="hidden" name="city"     id="city"     value="<?php echo $item['city']?>" />
									<input type="hidden" name="area"     id="area"     value="<?php echo $item['area']?>" />
								</li>
								<li>
									<span class="m-name">
										详细地址：
									</span>
									<input type="text" name="addr" id="addr" value="<?php echo $item['addr']?>" size="80"  style="width:550px"  datatype="*"/>
							  	</li>
								<li>
									<span class="m-name">
										联系人：
									</span>
									<input type="text" name="contact" id="contact" value="<?php echo $item['contact']?>"  datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										手机：
									</span>
									<input type="text" name="mobile" id="mobile" value="<?php echo $item['mobile']?>"  datatype="m"/>
								</li>
								<li>
									<span class="m-name">
										邮箱：
									</span>
									<input type="text" name="email" id="email" value="<?php echo $item['email']?>" />
								</li>
								<li style="height: 150px;">
									<span class="m-name">
										其他信息：
									</span>
									<textarea name="remark" id="remark" name="other" rows="9" cols="77"><?php echo $item['remark']?></textarea>
								</li>
								<li>
									<span class="m-name">
										状态设置：
									</span>
									
									<input type="radio" name="status" value="0" class="checkbox" <?php if ($item['status'] == 0) echo 'checked="checked"'?> />
									<span class="m-name1">试用</span>
									
									<input type="radio" name="status" value="1" class="checkbox" <?php if ($item['status'] == 1) echo 'checked="checked"'?> />
									<span class="m-name1">正常</span>
									
									<input type="radio" name="status" value="2" class="checkbox" <?php if ($item['status'] == 2) echo 'checked="checked"'?> />
									<span class="m-name1">过期</span>
								</li>
								<li>
									<span class="m-name">
										开通日期：
									</span>
									<input type="created_at" id="created_at" value="<?php echo $item['created_at']?>"  datatype="*"/>
								</li>
								<li>
									<span class="m-name">
										开通周期：
									</span>
									<select name="service_days" id="service_days" datatype="*">
										<?php foreach ( $service_days as $v ) : ?>
										<option value="<?php echo $v['days']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
									<span>
									  2014年08月26号-2015年09月25号
									</span>
								</li>
							</ul>							
						</div>
						
						</form>
						
						
						<div class="accountSettings-title">
							菜单地址
						</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name3">
										+机构&nbsp;>
									</span>
									<input type="text" />
									<span class="m-name3">
										+信息&nbsp;>
									</span>
									<input type="text" />
									<span class="m-name3">
										+学生&nbsp;>
									</span>
									<input type="text" />
								</li>
								<li>
									<span class="m-name3">
										-机构介绍&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/agency?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-作业任务&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/task?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-学生成绩&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/report?uuid=<?php echo $item['username']?>"/>
								</li>
								<li>
									<span class="m-name3">
										-师资力量&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/agency/teachers?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-学生作品&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/agency/works?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-老师评语&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/comment?uuid=<?php echo $item['username']?>"/>
								</li>
								<li>
									<span class="m-name3">
										-机构动态&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/news?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-每日讯息&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/dailynews?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-我要反馈&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/feedback?uuid=<?php echo $item['username']?>"/>
								</li>
								<li>
									<span class="m-name3">
										-知识分享&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/article?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-精英榜&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/top?uuid=<?php echo $item['username']?>"/>
									<span class="m-name3">
										-我要报名&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/class?uuid=<?php echo $item['username']?>&for=signup"/>
								</li>
								<li>
									<span class="m-name3">
										-课程介绍&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/class?uuid=<?php echo $item['username']?>"/>
								</li>
                                <li>
									<span class="m-name3">
									</span>
									<input type="text" value=""/>
								</li>
                                <li>
									<span class="m-name3">
										-学生资料&nbsp;>
									</span>
									<input type="text" value="http://www.honham.com:86/index.php/student/infor?uuid=<?php echo $item['username']?>"/>
								</li>
								<li style="text-align: center;">
									<i class="tishi">
										此别名设置直接映射到客户管理后台的菜单上的名称，方便客户自定义
									</i>
								</li>
							</ul>
						</div>
						<div class="sendbutton" id="btnSubmit">确定修改</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>
</html>
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	setup();preselect_ex(0,0,0);
	
	$('#btnSubmit').click(function(){
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
		datatype:{
			"zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/
		},
	});
	
	//通过$.Tipmsg扩展默认提示信息;
	//$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
})
</script>
