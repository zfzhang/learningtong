<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>客户管理</title>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/base.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo URL::base()?>css/manage.css"/>
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
					<a href="#">首页</a><a class="lastc"><span>></span> 机构查询</a>
				</div>
				<div class="contentList">
					<div class="accountSettings">
						<div class="accountSettings-title">
							条件检索
						</div>
						<div class="accountSettings-box">
							<ul>
								<li>
									<span class="m-name">
										名称：
									</span>
									<input type="text" class="data-field" id="viewname" />
									<span class="m-name">
										微信号：
									</span>
									<input type="text" class="data-field" id="weixin" />
									<span class="m-name">
										微信原始号：
									</span>
									<input type="text" class="data-field" id="weixin_id" />
								</li>
								<li>
									<span class="m-name">
										状态：
									</span>
									<select class="data-field" id="status">
										<option value="0">试用</option>
										<option value="1">正常</option>
										<option value="2">过期</option>
									</select>
									
									<span class="m-name">
										缴费类型：
									</span>
									<select class="data-field" id="pay_type">
										<?php foreach ( $pay_types as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
									
									<span class="m-name">
										客户类型：
									</span>
									<select class="data-field" id="type">
										<?php foreach ( $client_types as $v ) : ?>
										<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										地区：
									</span>
									
									<select class="data-field" id="province">
									</select>
									
									<select class="data-field" id="city">
										<option value="">请选择城市</option>
									</select>
									
									<select class="data-field" id="area">
										<option value="">请选择地区</option>
									</select>
									
								</li>
								<li>
									<span class="m-name">
										地址：
									</span>
									<input type="text" class="data-field" id="addr" />
									<span class="m-name">
										联系人：
									</span>
									<input type="text" class="data-field" id="contact" />
									<span class="m-name">
										手机：
									</span>
									<input type="text" class="data-field" id="mobile" />
								</li>
							</ul>
						</div>
						<div class="sendbutton">搜索</div>
						<br/><br/><br/><br/><br/>
						<div class="table-cell">
							<table border=".5" cellspacing="0" cellpadding="0">
								<tr>
									<th>序号</th>
									<th>客户名称</th>
									<th>地区</th>
									<th>联系人</th>
									<th>手机</th>
									<th>添加时间</th>
									<th>客户类型</th>
									<th>操作</th>
								</tr>
								<?php foreach($items as $v):?>
								<tr>
									<td><?php echo $v['id']?></td>
									<td><?php echo $v['realname']?></td>
									<td><?php echo $v['addr']?></td>
									<td><?php echo $v['contact']?></td>
									<td><?php echo $v['mobile']?></td>
									<td><?php echo $v['created_at']?></td>
									<td>
										<?php
										foreach ( $client_types as $t ) {
											if ( $t['id'] == $v['client_type_id'] ) {
												echo $v['name'];
												break;
											}
										}
										?>
									</td>
									<td>
										<a href="<?php echo URL::base(NULL, TRUE)?>agency/edit/?id=<?php echo $v['id']?>">编辑</a>
										<?php if ( $v['status'] == STATUS_DISABLED ) :?>
										<a href="#">已停用</a>
										<?php else:?>
										<a href="<?php echo URL::base(NULL, TRUE)?>agency/disable/?id=<?php echo $v['id']?>">停用</a>
										<?php endif?>
									</td>
								</tr>
								<?php endforeach?>
							</table>
							<div class="pagenav">
								<?php echo $html_pagenav_content?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">Copyright&copy;2006-2014 弘翰学信通</div>
	</body>
</html>
