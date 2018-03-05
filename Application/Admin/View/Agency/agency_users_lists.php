<form id="pagerForm" method="post" action="/admin/Agency/agency_users_lists?ag_id=<?php echo I('get.ag_id');?>">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/Agency/agency_users_lists?ag_id=<?php echo I('get.ag_id');?>" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				<label>名称：</label>
				<input type="text" name="name" size="20" value="<?php echo I('post.name','');?>"/>
			</li>
			<li>
				<label>用户类型：</label>
				<select name="type">
					<option value="0" <?php echo I('post.type',0,'intval')==0 ? 'selected' : '';?> > 全部</option>
					<option value="1" <?php echo I('post.type',0,'intval')==1 ? 'selected' : '';?> >学生</option>
					<option value="2" <?php echo I('post.type',0,'intval')==2 ? 'selected' : '';?> >前台</option>
					<option value="3" <?php echo I('post.type',0,'intval')==3 ? 'selected' : '';?> >老师</option>
					<option value="4" <?php echo I('post.type',0,'intval')==4 ? 'selected' : '';?> >老板</option>
				</select>
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
		</ul>
 
	</div>
	</form>
</div>
<div class="pageContent">
	<?php if(checkPermission('add_agency_users')){?>
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/admin/Agency/add_agency_users?ag_id=<?php echo I('get.ag_id');?>" target="dialog" width="600" height="400"mask="true" maxable="false" ><span>关联用户</span></a></li>
		</ul>
	</div>
	<div layoutH="92">
	<?php }else{?>
	<div layoutH="65">
	<?php }?>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th class="left" width="2%"><input type="checkbox" group="gids" class="checkboxCtrl"></th>
				<th class="center" width="4%">ID</th>
				<th class="center" >机构</th>
				<th class="center" width="8%">用户</th>
				<th class="center" width="8%">用户类型</th>
				<th class="center" width="12%">预留电话1</th>
				<th class="center" width="12%">预留电话2</th>
				<th class="center" width="12%">创建时间</th>
				<th class="center" width="8%">状态</th>
				<th class="center" width="8%" nowrap="nowrap">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($result as $item){?>
			<tr target="sid_user" rel="<?php echo $item['id'];?>">
				<td>
					<input name="gids" value="<?php echo $item['id']?>" type="checkbox">
				</td>
				<td class="center"><?php echo $item['id']?></td>
				<td class="center"><?php echo $item['agency_name'];?></td>
				<td class="center"><?php echo $item['user_name'];?></td>
				<td class="center">
					<?php 
						switch($item['user_type']){
							case 1:
								echo '学生';
								break;
							case 2:
								echo '前台';
								break;
							case 3:
								echo '老师';
								break;
							case 4:
								echo '老板';
								break;
							default :
								echo '未知';
								break;
						}

					?>
				</td>
				<td class="center"><?php echo $item['mobile'];?></td>
				<td class="center"><?php echo $item['tel_phone'];?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['create_time']);?></td>
				<td class="center"><?php echo $item['status']==1 ? '可用' : '<font color="red">禁用</font>';?></td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('edit_agency_users')){?>
					<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_agency_users"  width="600" height="350" href="/admin/Agency/edit_agency_users?ag_id=<?php echo I('get.ag_id');?>&id=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_agency_users')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/Agency/del_agency_users?id=<?php echo $item['id'];?>">删除</a>
					<?php }?>
				</td>
			</tr>

			<?php }?>
		</tbody>
	</table>
	</div>
	<div class="panelBar">
		<div class="pages">
			<span>显示</span>
			<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20" <?php if($per_page==20) echo 'selected'?>>20</option>
				<option value="30" <?php if($per_page==30) echo 'selected'?>>30</option>
				<option value="40" <?php if($per_page==40) echo 'selected'?>>40</option>
				<option value="50" <?php if($per_page==50) echo 'selected'?>>50</option>
			</select>
			<span>条，共<?php echo $total_rows;?>条&nbsp&nbsp</span>
		   
		   
			  
		</div>
		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $total_rows;?>" numPerPage="<?php echo $per_page; ?>" pageNumShown="10" currentPage="<?php echo $current_page; ?>"></div>

	</div>
</div>
<script type="text/javascript">

</script>
