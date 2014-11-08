<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>课程介绍</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<a onclick="history.back()" style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title"><?php echo $class['name']?>课程介绍</h1>
		</header>
		<div class="mui-content" style="padding-bottom: 10px; margin-bottom:10px;">
			<?php if ( isset($for) and $for == 'signup' ) : ?>
			<div class="course-detail-note">
				<?php echo $explain?>
			</div>
			<?php else : ?>
			<div class="course-detail-note">
				<?php echo $class['content']?>
			</div>
			<?php endif?>
			<?php foreach ( $items as $v ) : ?>
		
			<div class="course-detail">
				<div class="table-cell">
					<table border="1" bordercolor="#b1b1b1" cellspacing="0" cellpadding="0">
						<tr>
							<td>班别名称</td>
							<td><?php echo $v['name']?></td>
						</tr>
						<tr>
							<td>课程内容</td>
							<td><?php echo $v['content']?></td>
						</tr>
						<tr>
							<td>上课时间</td>
							<td><?php echo $v['time']?></td>
						</tr>
						<tr>
							<td>课时</td>
							<td><?php echo $v['hours']?></td>
						</tr>
						<tr>
							<td>学费</td>
							<td><?php echo $v['tuition']?></td>
						</tr>
						<tr>
							<td>招生人数</td>
							<td><?php echo $v['num']?></td>
						</tr>
					</table>
				</div>
				
				<?php if ( isset($for) and $for == 'signup' ) : ?>
				<div class="sign-btn">
					<!--
					<div class="sign-left">
						<img src="images/zfb.png"/>
					</div>
					<div class="sign-right">
						登录支付宝直接付款给********@qq.com，支付宝连接地址：<a href="#">http://zhifubao.com</a>
						<br />付款说明中可以填入文字格式：姓名-家长/学生手机-报名班别
					</div>
					-->
					<div class="sign-box">
						<button id="btnSubmit" class="mui-btn mui-btn-success mui-btn-block" onclick="signup(<?php echo $v['id']?>)">
							已报名，马上递交资料
						</button>
					</div>
				</div>
				<?php endif?>
				
			</div>
			<?php endforeach?>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
function signup( course_id ) 
{
	window.location.href = '<?php echo URL::base("http", true)?>guest/signup/?course_id=' + course_id;
}
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {  
WeixinJSBridge.call('hideOptionMenu');  
});
</script>