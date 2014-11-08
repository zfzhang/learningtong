<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>参数设置</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/setting.css" />
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
					<a href="#">首页</a><a class="lastc"><span>></span> 参数设置</a>
				</div>
				<div class="contentList">
					<div class="set-nav">
						<a href="<?php echo URL::base(NULL, TRUE)?>clienttype/list/">客户类型</a>
						<a href="<?php echo URL::base(NULL, TRUE)?>paytype/list/">缴费方案</a>
						<a class="active" href="#">机构性质</a>
						<a href="<?php echo URL::base(NULL, TRUE)?>servicedays/list/">缴费周期</a>
					</div>
					<div class="setting-table">
						<div class="title"><a href="<?php echo URL::base(NULL, TRUE)?>agencytype/add/">增加机构性质</a></div>
						<table border="1" cellspacing="0" cellpadding="0">
							<tr><th>序号</th><th>名称</th><th>说明</th><th>操作</th></tr>
							<?php foreach ( $items as $v ) : ?>
							<tr>
								<td><?php echo $v['id']?></td>
								<td><?php echo $v['name']?></td>
								<td><?php echo $v['remark']?></td>
								<td><a href="<?php echo URL::base(NULL, TRUE)?>agencytype/edit/?id=<?php echo $v['id']?>">编辑</td>
							</tr>
							<?php endforeach?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>

</html>
