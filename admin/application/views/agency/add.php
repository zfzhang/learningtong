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
						
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										用户名：
									</span>
									<input type="text" name="username" id="username"  datatype="s6-18"  errormsg="用户名至少6个字符,最多18个字符！"/>
								</li>
								<li>
									<span class="m-name">
										公众号名称：
									</span>
									<input type="text" name="viewname"  id="viewname"  datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										微信号：
									</span>
									<input type="text" name="weixin"    id="weixin"  datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										微信原始号：
									</span>
									<input type="text" name="weixin_id" id="weixin_id" datatype="*"/>
								</li>
								<li>
									<span class="m-name">
										公众号appid：
									</span>
									<input type="text" name="wx_appid"  id="wx_appid" datatype="*"/>
                                </li>
								<li>
									<span class="m-name">
										公众号secret：
									</span>
									<input type="text" name="wx_secret" id="wx_secret" datatype="*"/>
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
									<input type="text" name="realname" id="realname"  datatype="*"/>
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
									<input type="text" name="entity_num" id="entity_num" size="3" maxlength="3"  style="width:40px" datatype="n1-3"/>
								</li>
                                <li>
									<span class="m-name">
										学生人数：
									</span>
									<input type="text" name="student_num" id="student_num" size="3" maxlength="3"  style="width:40px" datatype="n1-3"/>
								</li>
                                <li>
									<span class="m-name">
										短信模板：
									</span>
									<input type="text" name="sms_tpl_id" id="sms_tpl_id" size="4" maxlength="4"  style="width:50px" datatype="n1-4"/>
								</li>
                                <li>
                                	<span class="m-name">
										机构性质：
									</span>
									<select name="agency_type_id" id="agency_type_id" datatype="*">
										<?php foreach ( $agency_types as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
                                <li>	
									<span class="m-name">
										缴费方案：
									</span>
									<select name="pay_type_id" datatype="*">
										<?php foreach ( $pay_types as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">所在地区：</span>
									
									<select id="s1" datatype="*">
										<option value="">请选择省份</option>
									</select>
									
									<select id="s2" datatype="*">
										<option value="">请选择城市</option>
									</select>
									
									<select id="s3" datatype="*">
										<option value="">请选择地区</option>
									</select>
								
									<input type="hidden" name="province" id="province" value="0" />
									<input type="hidden" name="city"     id="city"     value="0" />
									<input type="hidden" name="area"     id="area"     value="0" />
								</li>
								<li>
									<span class="m-name">
										详细地址：
									</span>
									<input type="text" name="addr" id="addr" size="80"  style="width:550px"  datatype="*"/>
							  	</li>
								<li>
									<span class="m-name">
										联系人：
									</span>
									<input type="text" name="contact" id="contact"  datatype="*"/>
                                 </li>
                                <li>
									<span class="m-name">
										手机：
									</span>
									<input type="text" name="mobile" id="mobile"  datatype="m"/>
								</li>
								<li>
									<span class="m-name">
										邮箱：
									</span>
									<input type="text" name="email" id="email" />
								</li>
								<li style="height: 150px;">
									<span class="m-name">
										其他信息：
									</span>
									<textarea name="remark" id="remark" name="other" rows="9" cols="77"></textarea>
								</li>
								<li>
									<span class="m-name">
										状态设置：
									</span>
									
									<input type="radio" name="status" value="0" class="checkbox" checked="checked" />
									<span class="m-name1">试用</span>
									
									<input type="radio" name="status" value="1" class="checkbox" />
									<span class="m-name1">正常</span>
									
									<input type="radio" name="status" value="2" class="checkbox" />
									<span class="m-name1">过期</span>
								</li>
								<li>
									<span class="m-name">
										开通日期：
									</span>
									<input type="created_at" id="created_at" value="<?php echo date('Y-m-d')?>"  datatype="*"/>
								</li>
								<li>
									<span class="m-name">
										开通周期：
									</span>
									<select name="service_days" id="service_days"  datatype="*">
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
						
						<div class="accountSettings-title"></div>
						<div class="sendbutton" id="btnSubmit">确定添加</div>
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
