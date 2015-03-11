<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo $agency_name?> | 展示</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="<?PHP echo URL::base()?>css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/blue.css" />
		<link rel="stylesheet" type="text/css" href="<?PHP echo URL::base()?>css/article.css" />
		<style type="text/css">
			.show-img{
			  	width: 100%;
			  	background-color: #fff;
			  	border: 1px solid #EBE9E9;
			  	padding: 2%;
			  	margin-top: 10px;
			  }
			  .show-img:first-child{
			  	margin-top: 0;
			  }
			  .show-img img{
			  	width: 100%;
			  }
			  .show-img p{
			  	width: 100%;
			  	margin-top: 10px;
			  	margin-bottom: 0;
			  }
		</style>
	</head>

	<body class="bg-white">
		<div class="mui-content">
			<div id="segmentedControl" class="mui-segmented-control" style="margin: 0 auto;width: 96%;margin-top: 10px;">
				<a href="<?PHP echo URL::base(NULL, TRUE)?>agency/index?uuid=<?php echo $uuid?>" class="mui-control-item">

					简介

				</a>
				<a class="mui-control-item mui-active">

					展示

				</a>
				<a href="<?PHP echo URL::base(NULL, TRUE)?>agency/contact?uuid=<?php echo $uuid?>" class="mui-control-item">

					联系

				</a>
			</div>
			<div class="content-box" style="margin-top: 10px;">
				<?php foreach ( $items as $v ) :?>
				<div class="show-img">
					<img src="<?php echo $v['url']?>" />
					<p><?php echo $v['title']?></p>
				</div>
				<?php endforeach?>
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
var descContent = '展示';
var shareTitle  = '<?php echo $agency_name?>展示';
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
