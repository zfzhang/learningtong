<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>每日讯息</title>
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
			<h1 class="mui-title">每日讯息</h1>
		</header>
		<div class="mui-content">
			<ul id="list-box" class="mui-table-view mui-table-view-striped mui-table-view-condensed" style="margin-top: 0;">
				<?php foreach ( $items as $v ) : ?>
				<li class="mui-table-view-cell">
					<a href="<?php echo URL::base(NULL, TRUE),'dailynews/detail/?id=',$v['id'],'&uuid=',$uuid?>">
					<div class="mui-table">
						<div class="mui-table-cell mui-col-xs-9">
							<h4 class="mui-ellipsis"><?php echo $v['title']?></h4>
							<p class="mui-h6 mui-ellipsis"><?php echo $v['remark']?></p>
						</div>
						<div class="mui-table-cell mui-col-xs-3 mui-text-right">
							<span class="mui-h5"><?php echo substr($v['modified_at'], 0, 10)?></span>
						</div>
					</div>
					</a>
				</li>
				<?php endforeach?>
			</ul>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	var base_url  = '<?PHP echo URL::base(NULL, TRUE)?>/dailynews';
	var cur_page  = '<?php echo $page?>'; cur_page = parseInt(cur_page);
	var scrollEnd = true;
	
	var listbox = $('#list-box');
	
	$(window).scroll(function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		if ( scrollTop + windowHeight == scrollHeight ) {
			//页面滑动到底部时加载更多
			if ( scrollEnd ) {
				listbox.append('<li class="loading" style="text-align: center;color: #999;">数据正在加载中...</li>');
				scrollEnd = false;
				
				cur_page++;
				
				$.get( base_url, {page:cur_page}, function (jsonStr) {
					var list = $.parseJSON(jsonStr);
					$.each(list, function (k, v) {
						var li = '<li class="mui-table-view-cell">';
						li += '<a href="' + base_url + '/detail?id=' + v.id + '&uuid=<?php echo $uuid?>">';
						li += '<div class="mui-table">';
						li += '<div class="mui-table-cell mui-col-xs-10">';
						li += '	<h4 class="mui-ellipsis">' + v.title + '</h4>';
						li += '	<p class="mui-h6 mui-ellipsis">' + v.remark + '</p>';
						li += '</div>';
						li += '<div class="mui-table-cell mui-col-xs-2 mui-text-right">';
						li += '	<span class="mui-h5">' + v.modified_at + '</span>';
						li += '</div>';
						li += '</div>';
						li += '</a>';
						li += '</li>';
						listbox.append(li);
					});
					
					$('.loading').hide();
					scrollEnd = true;
				});
			}
		}
	});
});
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {  
WeixinJSBridge.call('hideOptionMenu');  
});
</script>
