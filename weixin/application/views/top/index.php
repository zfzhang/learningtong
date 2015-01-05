<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo $agency_name?> | 菁英榜</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>
	<body class="bg-white">
		<div class="mui-content">
			<div class="elite-inner">
				<div class="elite-title">
				<div class="title-img">
					<img src="<?PHP echo URL::base()?>images/jingying.jpg" alt="" />
				</div>
				<p><?php echo $item['begin_str'],' 到 ',$item['end_str']?></p>
			</div>
			<div class="mui-content-padded">
				<ul class="mui-pager">
					<li class="mui-previous">
						<a href="<?php echo URL::base(NULL, TRUE),'top?page=',$page + 1?>">
							<span class="mui-icon mui-icon-left-nav"></span>
							上一周榜单
						</a>
					</li>
					<li class="mui-next">
						<a href="<?php echo URL::base(NULL, TRUE),'top?page=',$page - 1?>">
							下一周榜单 <span class="mui-icon mui-icon-right-nav"></span>
						</a>
					</li>
				</ul>
			</div>
			<div class="elite-list">
				<?php foreach ( $students as $v ) : ?>
				<div class="student-box">
					<div class="stimg-box">
						<img src="<?php echo $v['avatar']?>"/>
						<p class="star"></p>
					</div>
					<div class="stcon-box">
						<ul>
							<li>
								<span class="st-title">姓名：</span><?php echo $v['realname']?>
							</li>
							<li>
								<span class="st-title">性别：</span><?php echo $v['sex'] ? '男' : '女'?>
							</li>
							<li>
								<span class="st-title">所在学校：</span><?php echo $v['school']?>
							</li>
							<li>
								<span class="st-title">所在年级：</span><?php echo $v['grade']?>
							</li>
							<li>
								<span class="st-title">机构班别：</span><?php //echo $v['class']?>
							</li>
							<li>
								<span class="st-title">上榜理由：</span>
							</li>
							<li>
								<?php echo $v['reason']?>
							</li>
						</ul>
					</div>
				</div>
				<?php endforeach?>
			</div>
			</div>
		</div>
		<?php echo $html_footer_content?>
	</body>

</html>
<script src="<?PHP echo URL::base()?>js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?PHP echo URL::base()?>js/setheight.js" type="text/javascript" charset="utf-8"></script>
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
var descContent = '菁英榜';
var shareTitle  = '<?php echo $agency_name?>菁英榜';
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