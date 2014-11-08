
				<div class="contentHead" style="padding-left: 5px;">
					<h3>管理菜单</h3>
				</div>
				<ul>
					<li <?php echo ($active=="baseinfo") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>system/index/">基本信息</a>
					</li>
					<li <?php echo ($active=="add_agency") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>agency/add/">开通客户</a>
					</li>
					<li <?php echo ($active=="agencies") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>agency/list/">客户管理</a>
					</li>
					<li <?php echo ($active=="backup") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>system/backup/">资料备份</a>
					</li>
					<li <?php echo ($active=="students") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>student/list/">数据查询</a>
					</li>
					<li <?php echo ($active=="setting") ? 'class="active"' : '';?>>
						<a href="<?php echo URL::base(NULL,TRUE)?>clienttype/list/">参数设置</a>
					</li>
					<li <?php echo ($active=="change_password") ? 'class="active"' : '';?> >
						<a href="<?php echo URL::base(NULL,TRUE)?>session/pswd/">密码修改</a>
					</li>
				</ul>
		