<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>弘翰文化</title>
	<link href="<?php echo URL::base()?>css/styles.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo URL::base()?>js/DD_roundies_min.js" type="text/javascript"></script>
    <script type="text/javascript">
	DD_roundies.addRule('.titleimagesdiv', '5px', true);
	</script>
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
				<div class="navOnIndex"><img src="<?php echo URL::base()?>images/on.png" alt="" /></div>
			</div>
		</div>
		<!-- 导航结束 -->
		<!-- Banner开始 -->
		<div class="banner">
			<div class="wrapper">
				<div id="slideshow" class="box_skitter fn-clear">
					<ul>
						<li><a href="#"><img src="<?php echo URL::base()?>images/b_0.jpg" alt="" /></a></li>
						<li><a href="#"><img src="<?php echo URL::base()?>images/b_0.jpg" alt="" /></a></li>
						<li><a href="#"><img src="<?php echo URL::base()?>images/b_0.jpg" alt="" /></a></li>
						<li><a href="#"><img src="<?php echo URL::base()?>images/b_0.jpg" alt="" /></a></li>
					</ul>
				</div>
				<script src="<?php echo URL::base()?>js/slideshow.js" type="text/javascript"></script>
			</div>
		</div>
		<!-- Banner结束 -->
	</div>
	<div class="main">
		<!-- 客户开始 -->
		<div class="user">
			<div class="userBar">客户</div>
			<div class="userBox">
				<div class="userItem">
					<div class="userImg"><a href="#"><img src="<?php echo URL::base()?>images/u_0.jpg" alt="" /></a></div>
					<div class="userTitle"><a href="#">广州知了教育有限公司</a></div>
				</div>
				<div class="userItem">
					<div class="userImg"><a href="#"><img src="<?php echo URL::base()?>images/u_1.jpg" alt="" /></a></div>
					<div class="userTitle"><a href="#">广州知了教育有限公司</a></div>
				</div>
				<div class="userItem">
					<div class="userImg"><a href="#"><img src="<?php echo URL::base()?>images/u_2.jpg" alt="" /></a></div>
					<div class="userTitle"><a href="#">广州知了教育有限公司</a></div>
				</div>
				<div class="userItemEnd">
					<div class="userImg"><a href="#"><img src="<?php echo URL::base()?>images/u_3.jpg" alt="" /></a></div>
					<div class="userTitle"><a href="#">广州知了教育有限公司</a></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<!-- 客户结束 -->
		<!-- 机构动态/我们的观点开始 -->
		<div class="info">
			<div class="infoUnit">
				<div class="infoUnitBar">
					<div class="infoUnitBarTit">机构动态</div>
					<div class="infoUnitBarMore"><a href="<?php echo URL::base(NULL, TRUE)?>agency/view">more</a></div>
					<div class="clear"></div>
				</div>
				<div class="infoUnitCont">
					<div class="infoUnitLeft">
						<div class="infoUnitLeftImg"><img src="<?php echo URL::base()?>images/bk.jpg" alt="" /></div>
						<div class="infoUnitLeftTit">
							<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[0]['id']?>">
								<?php echo $news[0]['title']?>
							</a>
						</div>
						<div class="infoUnitLeftCt">
							<?php echo $news[0]['remark']?>
						</div>
					</div>
					<div class="infoUnitRight">
						<div class="infoRightItem">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[1]['id']?>">
										<?php echo $news[1]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[1]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[1]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="infoRightItem">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[2]['id']?>">
										<?php echo $news[2]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[2]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[2]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="infoRightItemEnd">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[3]['id']?>">
										<?php echo $news[3]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[3]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[3]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="infoWnt">
				<div class="infoUnitBar">
					<div class="infoUnitBarTit">我们的观点</div>
					<div class="infoUnitBarMore"><a href="<?php echo URL::base(NULL, TRUE)?>agency/view">more</a></div>
					<div class="clear"></div>
				</div>
				<div class="infoUnitCont">
					<div class="infoUnitLeft">
						<div class="infoUnitLeftImg"><img src="<?php echo URL::base()?>images/bk.jpg" alt="" /></div>
						<div class="infoUnitLeftTit">
							<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[0]['id']?>">
								<?php echo $news[0]['title']?>
							</a>
						</div>
						<div class="infoUnitLeftCt">
							<?php echo $news[0]['remark']?>
						</div>
					</div>
					<div class="infoUnitRight">
						<div class="infoRightItem">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[1]['id']?>">
										<?php echo $news[1]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[1]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[1]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="infoRightItem">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[2]['id']?>">
										<?php echo $news[2]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[2]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[2]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="infoRightItemEnd">
							<div class="infoItemIts">
								<div class="infoItemImg titleimagesdiv" style="background:url(<?php echo URL::base()?>images/1.jpg)">
                                </div>
							</div>
							<div class="infoItemBts">
								<div class="infoItemTit">
									<a href="<?php echo URL::base(NULL, TRUE)?>agency/detail?id=<?php echo $news[3]['id']?>">
										<?php echo $news[3]['title']?>
									</a>
								</div>
								<div class="infoItemCts"><?php echo $news[3]['remark']?></div>
								<div class="infoItemDate"><?php echo substr($news[3]['modified_at'], 0, 10)?></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<!-- 机构动态/我们的观点结束 -->
	</div>
	<div class="footer">© 2005-2014 深圳市弘翰文化传播有限公司 版权所有</div>
</form>
</body>
</html>
