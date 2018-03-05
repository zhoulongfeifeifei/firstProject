<form id="pagerForm" method="post" action="/admin/Subject">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<div class="pageContent">
	<?php if(checkPermission('add_subject')){?>
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/admin/Subject/add_subject" target="dialog" width="600" height="250"mask="true" maxable="false" ><span>新建学科</span></a></li>
		</ul>
	</div>
	<div layoutH="55">
	<?php }else{?>
	<div layoutH="30">
	<?php }?>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th class="left" width="2%"><input type="checkbox" group="gids" class="checkboxCtrl"></th>
				<th class="center" width="4%">ID</th>
				<th class="center" >名称</th>
				<th class="center" width="12%">创建时间</th>
				<th class="center" width="12%">更新时间</th>
				<th class="center" width="12%">状态</th>
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
				<td class="center"><?php echo $item['update_time']>0 ? date('Y-m-d H:i:s',$item['update_time']) : '--';?></td>
				<td class="center"><?php echo $item['status']==1 ? '可用' : '<font color="red">禁用</font>';?></td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('edit_subject')){?>
					<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_subject"  width="600" height="250" href="/admin/Subject/edit_subject?id=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_subject')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/Subject/del_subject?id=<?php echo $item['id'];?>">删除</a>
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
