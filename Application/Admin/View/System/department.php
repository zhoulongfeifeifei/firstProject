<form id="pagerForm" method="post" action="/admin/System/department">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/System/department" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				<label>部门名称：</label>
				<input type="text" name="name" size="20" value="<?php echo I('post.name','');?>"/>
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
		</ul>
 
	</div>
	</form>
</div>
<div class="pageContent">
	<?php if(checkPermission('add_department')){?>
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/admin/System/add_department" target="dialog" width="900" height="400"mask="true" maxable="false" ><span>新建部门</span></a></li>
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
				<th class="center" >名称</th>
				<th class="center" width="12%">创建时间</th>
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
				<td class="center"><?php echo $item['name'];?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['create_time']);?></td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('edit_department')){?>
					<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_department"  width="900" height="400" href="/admin/System/edit_department?did=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_department')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/System/del_department?did=<?php echo $item['id'];?>">删除</a>
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
