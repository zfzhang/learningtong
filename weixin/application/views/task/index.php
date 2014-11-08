<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>作业任务</title>
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
			<label class="topbarlabel">请选择学生</label>
			<select class="topbarselect" id="change-student">
				<?php foreach ($students as $id => $v) : ?>
				<option value="<?php echo $id?>" <?php if ($id == $self) echo 'selected="selected"' ?> >
					<?php echo $v['realname']?>
				</option>
				<?php endforeach;?>
				<option value="0">------添加学生------</option>
			</select>
		</header>
		<div class="mui-content">
			<div class="elite-inner">
				<div class="elite-title">
					<div class="works-title-info">
						学校：<span><?php echo $school?></span>
						年级：<span><?php echo $grade?></span>
					</div>
					
					<?php $weekarray = array("日","一","二","三","四","五","六"); ?>
					<p>今天是：<?php echo date('Y年m月d日'),' ','星期'.$weekarray[date('w')]; ?></p>
				</div>
				<div class="mui-content-padded">
					<ul class="mui-pager">
						<li class="mui-previous">
							<a href="<?php echo URL::base(NULL, TRUE),'task/?page=',$page + 1?>">
								<span class="mui-icon mui-icon-left-nav"></span>前一天作业
							</a>
						</li>
						<li class="mui-next">
							<a href="<?php echo URL::base(NULL, TRUE),'task/?page=',$page - 1?>">
								下一天作业 <span class="mui-icon mui-icon-right-nav"></span>
							</a>
						</li>
					</ul>
				</div>
				<div class="today-work">
					<div class="work-title">
						<?php echo $item['class'],' ',$item['date_str'],' ', '作业'; ?>
					</div>
					<div class="content-works">
						<?php echo $item['content']; ?>
					</div>
				</div>
			</div>
		</div>
		
		<?php echo $html_footer_content?>
		
	</body>

</html>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?PHP echo URL::base()?>js/setheight.js"></script>
<script type="text/javascript" charset="utf-8">
$(function () {
	$('#change-student').change(function () {
		var student_id = $(this).val();
		if ( student_id == 0 ) {
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/add/';
		} else {
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/change/?id=' + student_id + '&uri=/task';
		}
	});
});
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {  
WeixinJSBridge.call('hideOptionMenu');  
});
</script>
