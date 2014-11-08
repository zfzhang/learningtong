<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>老师评语</title>
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
			</select>		</header>
		<div class="mui-content">
			<div class="comments">
				<ul id="list-box">
					<?php foreach ( $items as $v ) : ?>
					<li>
						<div class="editer">
							<span><?php echo $v['realname']?></span>
							<p><?php echo $v['begin_str'],' - ',$v['end_str']?></p>
						</div>
						<div class="comm-con">
							<?php echo $v['content']?>
						</div>
					</li>
					<?php endforeach?>
				</ul>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(function () {
	$('#change-student').change(function () {
		var student_id = $(this).val();
		if ( student_id == 0 ) {
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/add/';
		} else {
			window.location.href = '<?php echo URL::base(NULL, TRUE)?>student/change/?id=' + student_id + '&uri=/comment';
		}
	});
});
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {  
WeixinJSBridge.call('hideOptionMenu');  
});
</script>

<script type="text/javascript">
$(function(){
	var base_url  = '<?php echo URL::base(NULL, TRUE)?>comment';
	var cur_page  = '<?php echo $page?>'; cur_page = parseInt(cur_page);
	var scrollEnd = true;
	
	var listbox = $('#list-box');
	
	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		if(scrollTop + windowHeight == scrollHeight){
			//页面滑动到底部时加载更多
			if ( scrollEnd ) {
				listbox.append('<li class="loading">努力加载中...</li>');
				scrollEnd = false;
				
				cur_page++;
				
				$.get(base_url, {page:cur_page}, function (jsonStr) {
					var jsonObj = $.parseJSON(jsonStr);
					$.each(jsonObj, function (k, v) {
						var s = '<li>';
						s += '<div class="editer"><span>' + v.realname + '</span><p>' + v.begin_str + ' - ' + v.end_str + '</p></div>';
						s += '<div class="comm-con">' + v.content + '</div>';
						s += '</li>';
						
						listbox.append(s);
					});
					
					$('.loading').hide();
					scrollEnd = true;
				});
			}
		}
	});
});  
</script>
