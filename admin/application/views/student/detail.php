<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>资料备份</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/index.css"/>
	</head>
	<body>
		<div class="header">
			<?php echo $html_head_content?>
		</div>
		<div class="content">
			<div class="contentLeft">
				<?php echo $html_left_content?>
			</div>
			<div class="contentRight">
				<div class="contentHead">
					<a href="#">首页</a><a class="lastc"><span>></span> 学生资料</a>
				</div>
				<div class="contentBoxTitle">
					学生信息内容
				</div>
				<div class="contentList">
					<ul>
						<li>
							<span class="infoName">学生姓名：</span><span class="infoabout"><?php echo $item['realname']?></span>
						</li>
						<li class="odd">
							<span class="infoName">性别：</span>
							<span class="infoabout">
							<?php 
							if ( $item['sex'] == 1 ) {
								echo '男';
							} elseif ( $item['sex'] == 0 ) {
								echo '女';
							}
							?>
							</span>
						</li>
						<li>
							<span class="infoName">所在机构：</span><span class="infoabout"><?php echo $item['agency_name']?></span>
						</li>
						<li class="odd">
							<span class="infoName">所在地区：</span><span class="infoabout"><?php echo $item['agency_addr']?></span>
						</li>
						<li>
							<span class="infoName">电话：</span><span class="infoabout"><?php echo $item['mobile']?></span>
						</li>
						<li class="odd">
							<span class="infoName">父亲姓名：</span><span class="infoabout"><?php echo $item['father_name']?></span>
						</li>
						<li>
							<span class="infoName">父亲电话：</span><span class="infoabout"><?php echo $item['father_mobile']?></span>
						</li>
						<li class="odd">
							<span class="infoName">母亲姓名：</span><span class="infoabout"><?php echo $item['mother_name']?></span>
						</li>
						<li>
							<span class="infoName">母亲电话：</span><span class="infoabout"><?php echo $item['mother_mobile']?></span>
						</li>
						<li class="odd">
							<span class="infoName">家庭住址：</span><span class="infoabout"><?php echo $item['addr']?></span>
						</li>
						<li>
							<span class="infoName">所在学校：</span><span class="infoabout<?php echo $item['school']?>"><span>
						</li>
						<li class="odd">
							<span class="infoName">所在年级：</span><span class="infoabout"><?php echo $item['grade']?></span>
						</li>
						<li>
							<span class="infoName">机构班别：</span><span class="infoabout"><?php echo $item['courses']?><span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>
</html>
