<form id="pagerForm" method="post" action="/admin/WechatMaterial/index">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/WechatMaterial/index" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				<label>名称：</label>
				<input type="text" name="name" size="20" value="<?php echo empty(I('post.name'))? '' : I('post.name');?>"/>
			</li>
			<li style="width:200px;:">
				<label>类型：</label>
				<select name="type" class="type">
  					<option value="0" <?php echo I('post.type')==0 ? 'selected' : '';?>>全部</option>
  					<option value="1" <?php echo I('post.type')==1 ? 'selected' : '';?>>文本</option>
  					<option value="2" <?php echo I('post.type')==2 ? 'selected' : '';?>>图片</option>
  					<option value="3" <?php echo I('post.type')==3 ? 'selected' : '';?>>语音</option>
  					<option value="4" <?php echo I('post.type')==4 ? 'selected' : '';?>>视频</option>
  					<option value="5" <?php echo I('post.type')==5 ? 'selected' : '';?>>音乐</option>
  					<option value="6" <?php echo I('post.type')==6 ? 'selected' : '';?>>图文</option>
   				</select>
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
		</ul>
 
	</div>
	</form>
</div>
<style type="text/css">
	.imgText{
		font-size:14px;line-height:20px;
		width:220px;margin:0 auto;
		background:rgba(0,0,0,0.7);
		color:#fff;
	}
	.music{
		font-size:14px;line-height:20px;
	}
	#imgMaterial li{
		width:80px;
		height:80px;
		float:left;
		margin:5px;
		list-style-type: none;
	}
	#imgMaterial li img{
		width:80px;
		height:80px;
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
</style>
<div class="pageContent">
	<?php if(checkPermission('add_material')){?>
	<div class="panelBar">
		<ul class="toolBar">
			<li><a class="add" href="/admin/WechatMaterial/add_material" target="dialog" width="800" height="500"mask="true" maxable="false" ><span>添加素材</span></a></li>
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
				<th class="center" width="12%">名称</th>
				<th class="center" >内容</th>
				<th class="center" width="6%">类型</th>
				<th class="center" width="6%">状态</th>
				<th class="center" width="12%">添加时间</th>
				<th class="center" width="12%">有效期</th>
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
				<?php 
					switch($item['type']){
						case 1:
							$str= '文本';
							$content = $item['content'];
						 break;
						 case 2:
							$str= '图片';
							$content = '<img src="'.trim($item['contenturl'],'.').'" height="80px"/>';
						 break;
						 case 3:
							$str= '语音';
							$content = '<audio controls="controls"><source src="'.trim($item['contenturl'],'.').'" />无法播放</audio>';
						 break;
						 case 4:
							$str= '视频';
							$content = '<video src="'.trim($item['contenturl'],'.').'" controls="controls" width="240px">加载失败或者资源错误</video>';
						 break;
						 case 5:
							$str= '音乐';
							$content =  '<p class="music">'.$item['title'].'</p><p>'.$item['description'].'</p><p>&nbsp</p><audio controls="controls"><source src="'.trim($item['contenturl'],'.').'" />无法播放</audio>';
						 break;
						 case 6:
							$str= '图文';
							$content = '<a href="'.$item['url'].'" target="_blank"><img src="'.$item['contenturl'].'"  height="80px"/><p class="imgText">'.$item['title'].'</p></a>';
						 break;
					}
					echo '<td class="center">'.$content.'</td>';
					echo '<td class="center">'.$str.'</td>';
				?>
				<td class="center"><?php echo $item['status']==1 ? '可用' : '禁用';?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['create_time']);?></td>
				<td class="center">
					<?php
						if($item['mediaid']){
							if($item['end_time']>0){
								if($item['end_time']>time()){
									echo date('Y-m-d H:i:s',$item['end_time']);
								}else{
									echo '<font color="red">已过期</font>';
								}
							}else{
								echo '永久有效';
							}
						}else{
							echo '本地素材';
						}
					 ?>
				</td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('edit_material')){?>
					<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_material"  width="800" height="500" href="/admin/WechatMaterial/edit_material?id=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_material')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/WechatMaterial/del_material?id=<?php echo $item['id'];?>">删除</a>
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
