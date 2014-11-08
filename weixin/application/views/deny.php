<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>温馨提示</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.css"/>
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/default.date.css"/>
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<style type="text/css">
			.warm-com {
				margin: 0 auto;
				width: 96%;
				background: #f0f0f0;
				padding: 20px;
				margin-bottom: 20px;
				box-shadow: 0 0 5px #ccc;
				margin-top: -10px;
				text-align:center;
			}
			.warm-com p{
				color: #f00;
				font-weight:bold;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">温馨提示</h1> 
		</header>
		<div class="mui-content">
        	<br/>
			<div class="warm-com">
				<p style="font-size:1em;">报名成为我们的学员，您将得到授权，访问您的个人数据，让您能够第一时间看到学生所有信息。</p>
			</div>
			<div class="sign-box">
    			<a class="mui-btn mui-btn-success mui-btn-block" href="<?php echo URL::base(NULL, TRUE)?>guest/valid/">
    				已报名，马上验证使用全部功能
    				</a>
				<a class="mui-btn mui-btn-success mui-btn-block" href="<?php echo URL::base(NULL, TRUE)?>class/?for=signup">
					未报名，马上报名
				</a>
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
