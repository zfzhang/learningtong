<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>资料修改</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
        <link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/validstyle.css" />
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<style type="text/css">
			.address-box label~select {
				width: 21%;
			}
			.mui-input-row label {
				width: 35%;
				height: 40px;
				padding: 0px 15px;
				line-height: 43px;
			}
		</style>
		
		<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">完善资料</h1> 
		</header>
		<div class="mui-content">
			<div class="mui-content-padded" style="margin:10px;">
				<form method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>student/save/">
                	<div class="mui-input-row">
						<label class="title-color">您是</label>
						<input type="hidden" name="signup_by" value="3" />
                        <input type="text" id="signup" value="成人学员" readonly>
					</div>
					<div class="mui-input-row">
						<label class="title-color">学员姓名</label>
						<?php echo $item['realname']?>
					</div>
					<div class="mui-input-row">
						<label class="title-color">性别</label>
						<div class="sex-box" style="line-height: 40px;" datatype="*">
							<?php 
							if ( $item['sex'] == 1 ) {
								echo '男';
							} elseif ( $item['sex'] == 0 ){
								echo '女';
							}
							?>
						</div>
					</div>
					<div class="mui-input-row">
						<label class="title-color">出生日期</label>
						<?php echo $item['birthday']?>
					</div>
					<div class="mui-input-row">
						<label class="title-color">手机号码</label>
						<input type="text" class="text-color" placeholder="填写手机号码" name="mobile" id="mobile" value="<?php echo $item['mobile']?>" datatype="m" ignore="ignore" errormsg="请输入正确的手机号！">
					</div>
					<div class="mui-input-row">
						<label class="title-color">QQ</label>
						<input type="text" class="text-color" placeholder="填写QQ号码" name="QQ" id="QQ" value="">
					</div>
					<div class="mui-input-row">
						<label class="title-color">邮箱</label>
						<input type="text" class="text-color" placeholder="填写邮箱" name="mail" id="mail" value="">
					</div>
					<div class="mui-input-row address-box">
						<label class="title-color">所在区域</label>
                        <ul style="list-style:none; margin-left:80px; margin-top:0px;">
                        	<li style="float:left;width:100%">
                            <select id="s1" datatype="*" class="text-color">
							<option value="">请选择省份</option>
							</select>
                            </li>
                            <li style="float:left;width:100%">
                            <select id="s2" datatype="*" class="text-color">
							<option value="">请选择城市</option>
							</select>
                            </li>
                            <li style="float:left;width:100%">
                            <select id="s3" datatype="*" class="text-color">
							<option value="">请选择地区</option>
							</select>
                            </li>
                        </ul>
						<input type="hidden" name="province" id="province" value="<?php echo $item['province']?>" />
						<input type="hidden" name="city"     id="city"     value="<?php echo $item['city']?>" />
						<input type="hidden" name="area"     id="area"     value="<?php echo $item['area']?>" />
					</div>
					<div class="mui-input-row">
						<label class="title-color">家庭住址</label>
						<input type="text" class="text-color" placeholder="填写您的家庭地址" name="addr" id="addr" value="<?php echo $item['addr']?>" datatype="*" nullmsg="请输入地址！" errormsg="请输入地址！">
					</div>
				</div>
			</form>
			<div class="mui-input-row" style="margin: 10px 5px;">
				<button class="mui-btn mui-btn-block bg-color" id="btnSubmit">确认修改</button>
			</div>
		</div>
		</div>


		<style type="text/css">
			h5 {
				margin: 5px 7px;
			}
		</style>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/geo.js"></script>

<script type="text/javascript" charset="utf-8">
$(function () {
	var s1 = '<?php echo $item["province"]?>';
	var s2 = '<?php echo $item["city"]?>';
	var s3 = '<?php echo $item["area"]?>';
	setup();preselect_ex(s1,s2,s3);
	
	var parseClick = false;
	$('#btnSubmit').click(function () {
		if ( parseClick ) {
			return;
		}
		parseClick = true;
		
		$('#data-form').submit();
	});
});
</script>
<script type="text/javascript">
$(function(){
	//$(".registerform").Validform();  //就这一行代码！;
	
	$.Tipmsg.r=null;
		
	var showmsg=function(msg){//假定你的信息提示方法为showmsg， 在方法里可以接收参数msg，当然也可以接收到o及cssctl;
		alert(msg);
	}
	
	$(".registerform").Validform({
		tiptype:function(msg){
			showmsg(msg);
		},
		tipSweep:true,
		ajaxPost:true
	});
})
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {  
WeixinJSBridge.call('hideOptionMenu');  
});
</script>
