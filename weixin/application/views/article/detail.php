<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>文章内容</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
	</head>

	<body class="bg-white">
		<header class="mui-bar mui-bar-nav bg-color">
			<a onclick="history.back()" style="color: #fff;" class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<a class="mui-pull-right" style="color: #fff;margin-top: 10px;">
				<span class="mui-badge mui-badge-red"><?php echo $item['read_count'] + 1?></span>
			</a>
		</header>
		<div class="mui-content">
			<div class="content-title">
				<h4><?php echo $item['title']?></h4>
				<p>
					
					<span class="addtime">
					<?php echo $item['src'],'  ',$item['modified_at'];?>
					</span>
				</p>
			</div>
			<div class="content-box">
				<?php echo $item['content']?>
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
var descContent = '';
var shareTitle  = '<?php echo $item['title']?>';
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