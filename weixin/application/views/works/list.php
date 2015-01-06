<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>学生作品</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<script src="<?PHP echo URL::base()?>js/mui.min.js"></script>
		<script>
			mui.init();
		</script>
	</head>
	<body>
		<header class="mui-bar mui-bar-nav bg-color">
			<h1 class="mui-title">学生作品</h1>
		</header>
		<div class="mui-content">
			<div class="mui-slider">
		        <div class="mui-slider-group mui-slider-loop">
					<div class="mui-slider-item">
					</div>
					<?php foreach ( $images as $v ) : ?>
					<div class="mui-slider-item">
						<a href="<?php echo URL::base(NULL, FALSE),'?redirect=works-detail&id=',$v['id'],'&uuid=',$uuid?>">
							<img src="<?php echo $v['img']?>">
							<p class="mui-slider-title"><?php echo $v['title']?></p>
						</a>
					</div>
					<?php endforeach?>
					<div class="mui-slider-item">
					</div>
		        </div>
				<div class="mui-slider-indicator mui-text-right">
					<?php 
					$cnt = count($images);
					if ( $cnt ) {
						echo '<div class="mui-indicator mui-active"></div>';
						for ( $i = 1; $i < $cnt; $i++ ) {
							echo '<div class="mui-indicator"></div>';
						}
					}
					?>
				</div>
    		</div>
			<?php if ( count($items) > 0 ) : ?>
			<div class="mui-card">
				<ul id="list-box" class="mui-table-view">
					<li class="mui-table-view-cell mui-hidden">cared
						<div id="M_Toggle" class="mui-switch mui-active">
							<div class="mui-switch-handle"></div>
						</div>
					</li>
					<?php foreach ( $items as $v ) : ?>
					<li class="mui-table-view-cell mui-media">
						<a href="<?php echo URL::base(NULL, TRUE),'works/detail/?id=',$v['id']?>">
							<div class="mui-media-body mui-ellipsis">
								【<?php echo $students_courses[$v['student_id']]?>】
								<?php echo $v['student']?>同学的作品
								《<?php echo $v['title']?>》
								<p class='mui-ellipsis'><?php echo $v['remark']?></p>
							</div>
						</a>
					</li>
					<?php endforeach?>
				</ul>
			</div>
			<?php endif?>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	var base_url  = '<?PHP echo URL::base(NULL, FALSE)?>/works';
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
						li += '<a href="' + base_url + '/detail?id=' + v.id + '">';
						li += '<div class="mui-media-body mui-ellipsis">';
						li += '【' + v.class + '】';
						li += v.student + '同学的作品';
						li += '《' + v.title + '》';
						li += '<p class="mui-ellipsis">' + v.remark + '</p>';
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
</script>
<script type="text/javascript">
var this_url = window.location.href;
if ( this_url.indexOf('uuid') == -1 ) {
	if ( this_url.indexOf('?') == -1 ) {
		this_url += '?uuid=<?php echo $uuid?>';
	} else {
		this_url += '&uuid=<?php echo $uuid?>';
	}
}
var imgUrl      = "";
var lineLink    = this_url;
var descContent = '学生作品';
var shareTitle  = '<?php echo $agency_name?>学生作品';
var appid       = '';
        

$(function () {
	if ( $('img').length > 0 ) {
		imgUrl = $('img').eq(0).attr('src');
	}
	dataForWeixin.desc = dataForWeixin.title + '-' + $(document).attr('title');
});
          
        function shareFriend() {
            WeixinJSBridge.invoke('sendAppMessage',{
                "appid": appid,
                "img_url": imgUrl,
                "img_width": "200",
                "img_height": "200",
                "link": lineLink,
                "desc": descContent,
                "title": shareTitle
            }, function(res) {
                //_report('send_msg', res.err_msg);
            })
        }
        function shareTimeline() {
            WeixinJSBridge.invoke('shareTimeline',{
                "img_url": imgUrl,
                "img_width": "200",
                "img_height": "200",
                "link": lineLink,
                "desc": descContent,
                "title": shareTitle
            }, function(res) {
                   //_report('timeline', res.err_msg);
            });
        }
        function shareWeibo() {
            WeixinJSBridge.invoke('shareWeibo',{
                "content": descContent,
                "url": lineLink,
            }, function(res) {
                //_report('weibo', res.err_msg);
            });
        }
        // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
        document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
            // 发送给好友
            WeixinJSBridge.on('menu:share:appmessage', function(argv){
                shareFriend();
            });
            // 分享到朋友圈
            WeixinJSBridge.on('menu:share:timeline', function(argv){
                shareTimeline();
            });
            // 分享到微博
            WeixinJSBridge.on('menu:share:weibo', function(argv){
                shareWeibo();
            });
        }, false);


</script>
