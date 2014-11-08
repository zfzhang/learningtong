<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>学生查询</title>
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
					<a href="#">首页</a><a class="lastc"><span>></span> 学生查询</a>
				</div>
				<div class="contentList">
					<div class="accountSettings">
						<div class="accountSettings-title">
							条件检索
						</div>
						<div class="accountSettings-box">
							<form method="get" id="data-form" action="<?php echo URL::base(NULL, true)?>student/list/">
							<ul>
								<li>
									<span class="m-name">
										姓名：
									</span>
									<input type="text" name="realname" id="realname"/>
									<span class="m-name">
										性别：
									</span>
									<select name="sex" id="sex">
										<option value="1">男</option>
										<option value="0">女</option>
									</select>
									<span class="m-name">
										所在学校：
									</span>
									<select name="school" id="school">
										<option value=""></option>
										<?php foreach ( $schools as $school ) : ?>
										<option value="<?php echo $school['id']?>"><?php echo $school['name']?></option>
										<?php endforeach?>
									</select>
								</li>
								<li>
									<span class="m-name">
										所在班级：
									</span>
									<select name="grade" id="grade">
										<option value=""></option>
										<?php foreach ( $grades as $grade ) : ?>
										<option value="<?php echo $grade['id']?>"><?php echo $grade['name']?></option>
										<?php endforeach?>
									</select>
									<span class="m-name">
										手机号码：
									</span>
									<input type="text" name="mobile" id="mobile"/>
									<span class="m-name">
										父亲姓名：
									</span>
									<input type="text" name="father_name" id="father_name"/>
								</li>
								<li>
									<span class="m-name">
										父亲手机：
									</span>
									<input type="text" name="father_mobile" id="father_mobile"/>
									<span class="m-name">
										母亲姓名：
									</span>
									<input type="text" name="mother_name"   id="mother_name"/>
									<span class="m-name">
										母亲手机：
									</span>
									<input type="text" name="mother_mobile" id="mother_mobile"/>
								</li>
								<li>
									<span class="m-name">
										机构班别：
									</span>
									<select name="class" id="class"></select>
								</li>
								<li>
									<span class="m-name">
										所属机构：
									</span>
									<select name="agency" id="agency_id">
									<?php foreach ( $agencies as $agency ) : ?>
										<option value="<?php echo $agency['id']?>"><?php echo $agency['realname']?></option>
									<?php endforeach?>
									</select> 
								</li>
							</ul>
							</form>
						</div>
						<div class="sendbutton" id="btnSearch">搜索</div>
						<br/><br/><br/><br/><br/>
						<div class="table-cell">
							<table border=".5" cellspacing="0" cellpadding="0">
								<tr>
									<th>序号</th>
									<th>姓名</th>
									<th>性别</th>
									<th>所在区域</th>                              
									<th>学校</th>
									<th>年级</th>
									<th>手机号</th>
									<th>机构班别</th>
								</tr>
								<?php foreach($items as $v) :?>
								<tr onclick="location.href='<?php echo URL::base(NULL, TRUE)?>student/detail/?id=<?php echo $v['id']?>'">
									<td><?php echo $v['id']?></td>
									<td><?php echo $v['realname']?></td>
									<td><?php echo $v['sex']?></td>
									<td><?php echo $v['addr']?></td>
									<td><?php echo $v['school']?></td>
									<td><?php echo $v['grade']?></td>
									<td><?php echo $v['mobile']?></td>
									<td><?php echo @implode('<br/>', $student_classes[$v['id']])?></td>
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
<script type="text/javascript" charset="utf-8" src="<?php echo URL::base()?>js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#btnSearch').click(function(){
		$('#data-form').submit();
	});
});
</script>
