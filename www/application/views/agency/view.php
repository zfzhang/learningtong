<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>弘翰文化</title>
	<link href="<?php echo URL::base()?>css/styles.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo URL::base()?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo URL::base()?>js/view.js" type="text/javascript"></script>
</head>
<body>
<form>
	<div class="header">
		<!-- 顶部登录开始 -->
		<div class="top">
			<div class="topLogin">
				<a href="http://www.honham.com:81">客户登陆</a>
			</div>
		</div>
		<!-- 顶部登录结束 -->
		<!-- Logo开始 -->
		<div class="logo">
			<img src="<?php echo URL::base()?>images/logo.jpg" alt="" />
		</div>
		<!-- Logo结束 -->
		<!-- 导航开始 -->
		<div class="nav">
			<div class="navBox">
				<div class="navSplit"></div>
				<div class="navMenu"><a href="<?php echo URL::base(NULL, TRUE)?>agency/index">首 页</a></div>
				<div class="navSplit"></div>
				<div class="navMenu"><a href="<?php echo URL::base(NULL, TRUE)?>agency/view">动态观点</a></div>
				<div class="navSplit"></div>
				<div class="navMenu"><a href="<?php echo URL::base(NULL, TRUE)?>agency/solution">服务内容</a></div>
				<div class="navSplit"></div>
				<div class="navMenu"><a href="<?php echo URL::base(NULL, TRUE)?>agency/pro">学信通</a></div>
				<div class="navSplit"></div>
				<div class="navMenu"><a href="<?php echo URL::base(NULL, TRUE)?>agency/us">我们</a></div>
				<div class="navSplit"></div>
				<div class="clear"></div>
				<div class="navOnView"><img src="<?php echo URL::base()?>images/on.png" alt="" /></div>
			</div>
		</div>
		<!-- 导航结束 -->
		<!-- Banner开始 -->
		<div class="banner">
			<a href="#"><img src="<?php echo URL::base()?>images/b_0.jpg" alt="" /></a>
		</div>
		<!-- Banner结束 -->
	</div>
	<div class="main">
		<div class="listTag">
			<div class="listTagBk">机构动态</div>
			<div class="listTagBk">我们的观点</div>
			<div class="clear"></div>
		</div>
		<!-- 机构动态列表开始 -->
		<div class="listBox">
			<?php foreach ($news as $v) : ?>
			<div class="listItem">
				<div class="listItemTd">
					<div class="listItemTitle">
						<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $v['id']?>">
							<?php echo $v['title']?>
						</a>
					</div>
					<div class="listItemDate">【<?php echo substr($v['modified_at'], 0, 10)?>】</div>
					<div class="clear"></div>
				</div>
				<div class="listItemCont">
					<?php echo $v['remark']?>
					<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $v['id']?>">[详细]</a>
				</div>
			</div>
			<?php endforeach;?>
			<!-- 翻页开始 -->
			<div class="listPage">
				<span>共35条信息</span><a href="#" class="listPageTb">上一页</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#" class="listPageTb">下一页</a>
			</div>
			<!-- 翻页结束 -->
		</div>
		<!-- 机构动态列表结束 -->
		<!-- 我们的观点列表开始 -->
		<div class="listBox">
			<?php foreach ($news as $v) : ?>
			<div class="listItem">
				<div class="listItemTd">
					<div class="listItemTitle">
						<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $v['id']?>">
							<?php echo $v['title']?>
						</a>
					</div>
					<div class="listItemDate">【<?php echo substr($v['modified_at'], 0, 10)?>】</div>
					<div class="clear"></div>
				</div>
				<div class="listItemCont">
					<?php echo $v['remark']?>
					<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $v['id']?>">[详细]</a>
				</div>
			</div>
			<?php endforeach;?>
			<!-- 翻页开始 -->
			<div class="listPage">
				<span>共35条信息</span><a href="#" class="listPageTb">上一页</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><a href="#" class="listPageTb">下一页</a>
			</div>
			<!-- 翻页结束 -->
		</div>
		<!-- 我们的观点列表结束 -->
	</div>
	<div class="footer">© 2005-2014 深圳市弘翰文化传播有限公司 版权所有</div>
</form>
</body>
</html>
