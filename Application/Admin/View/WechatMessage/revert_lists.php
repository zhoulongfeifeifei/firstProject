<form id="pagerForm" method="post" action="/admin/WechatMessage/revert_lists">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<style type="text/css">
	#material li{
		width:80px;
		height:130px;
		float:left;
		margin:5px;
		list-style-type: none;
	}
	#material li img{
		width:80px;
		height:80px;
	}
	#material li video{
		width:80px;
		height:80px;
	}
	#material li audio{
		width:80px;
		height:60px;
	}
	#searchMaterial{
		width:40px;
		height:25px;
		margin-left:10px;
		background:#1CAF9A;
		border:1px solid #1CAF9A;
		color:#fff;
	}

	.topage{
		width:12px;
		height:70px;
		float:left;
		font-size:20px;
		color:#999;
		padding-top:40px;
		margin-left:10px;
		background:#dddddd;
		border:1px solid #dddddd;
	}
	.img_text{
		height:18px;
		line-height: 18px;
		overflow: hidden;
	}
</style>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/WechatMessage/revert_lists" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				<label>名称：</label>
				<input type="text" name="name" size="20" value="<?php echo empty(I('post.name'))? '' : I('post.name');?>"/>
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
		</ul>
 
	</div>
	</form>
</div>
<div class="pageContent">
	<?php if(checkPermission('add_revert')){?>
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/admin/WechatMessage/add_revert" target="dialog" width="850" height="400"mask="true" maxable="false" ><span>添加自动回复</span></a></li>
		</ul>
	</div>
	<div layoutH="65">
	<?php }else{?>
	<div layoutH="38">
	<?php }?>
	<table class="table" width="100%">
		<thead>
			<tr>
				<th class="left" width="2%"><input type="checkbox" group="gids" class="checkboxCtrl"></th>
				<th class="center" width="4%">ID</th>
				<th class="center" >名称</th>
				<th class="center" width="12%">接收消息类型</th>
				<th class="center" width="12%">回复消息类型</th>
				<th class="center" width="12%">状态</th>
				<th class="center" width="15%">添加时间</th>
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
				<td class="center">
					<?php 
						switch($item['receive_type']){
							case 0:
								echo '关键词（文本）';
								break;
							case 1:
								echo "关注";
								break;
							case 2:
								echo "图片";
								break;
							case 3:
								echo "语音";
								break;
							case 4:
								echo "视频";
								break;
							case 5:
								echo '小视频';
								break;
							case 6:
								echo "地理位置";
								break;
							case 7:
								echo '链接';
								break;
						}

					?>
				</td>
				<td class="center">
					<?php 
						switch($item['revert_type']){
							case 1:
								echo "文本";
								break;
							case 2:
								echo "图片";
								break;
							case 3:
								echo "语音";
								break;
							case 4:
								echo "视频";
								break;
							case 5:
								echo '音乐';
								break;
							case 6:
								echo "图文";
								break;
						}

					?>
				</td>
				<td class="center"><?php echo $item['status']==1 ? '可用' : '禁用';?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['create_time']);?></td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('edit_revert')){?>
					<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_revert"  width="850" height="400" href="/admin/WechatMessage/edit_revert?id=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_revert')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/WechatMessage/del_revert?id=<?php echo $item['id'];?>">删除</a>
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
