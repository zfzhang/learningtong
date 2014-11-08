<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>增加客户类型</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/openclient.css"/>
        <link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/validstyle.css" />
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
					<a href="#">首页</a><a class="lastc"><span>></span> 参数设置</a>
				</div>
				<div class="contentList">
					<div class="accountSettings">
						<div class="accountSettings-title">修改缴费周期</div>
						<div class="accountSettings-box">
							<form class="registerform" method="post" id="data-form" action="<?php echo URL::base(NULL, true)?>servicedays/save/">
							<input type="hidden" name="id" value="<?php echo $item['id']?>" />
							<ul>
								<li>
									<span class="m-name">名称：
									</span>
									<input type="text" name="name" id="name" value="<?php echo $item['name']?>"  datatype="*"/>
								</li>
                                <li style="height: 100px;">
									<span class="m-name">说明：
									</span>
									<textarea name="remark" rows="4" cols="77"><?php echo $item['remark']?></textarea>
								</li>
							</ul>
							</form>
						</div>
						<div id="btnSubmit" class="sendbutton">确定修改</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>
</html>

<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/Validform_v5.3.2.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
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
	});
	
	//通过$.Tipmsg扩展默认提示信息;
	//$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
})
</script>