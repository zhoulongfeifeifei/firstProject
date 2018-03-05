<form id="pagerForm" method="post" action="/admin/WechatUsers/index">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<style type="text/css">
	.msg_notice{
		width:15px;
		height:15px;
		border-radius: 15px;
		background:red;
		color:#fff;
		font-size:7px;
		float:left;
		position: absolute;
		margin:-5px 0 0 -13px;
	}
</style>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/WechatUsers/index" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				<label>用户昵称：</label>
				<input type="text" name="nickname" size="20" value="<?php echo I('post.nickname','');?>"/>
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit" id="users_search_button">检索</button></div></div></li>
		</ul>
 
	</div>
	</form>
</div>
<div class="pageContent">
	<div layoutH="65">
	<table class="table" width="100%">
		<thead>
			<tr>
				<th class="left" width="2%"><input type="checkbox" group="gids" class="checkboxCtrl"></th>
				<th class="center" width="4%">ID</th>
				<th class="center" width="8%">头像</th>
				<th class="center" >昵称</th>
				<th class="center" width="8%">城市</th>
				<th class="center" width="15%">关注状态</th>
				<th class="center" width="12%">关注时间：</th>
				<th class="center" width="8%">个人二维码</th>
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
				<td class="center"><img src="<?php echo $item['headimgurl'];?>" width="30px;" height="30px"/></td>
				<td class="center"><?php echo $item['nickname'];?></td>
				<td class="center"><?php echo $item['province'].'&nbsp&nbsp'.$item['city'];?></td>
				<td class="center"><?php echo $item['subscribe'] ==1 ? '正常' : date('m-d H:i',$item['unsubscribe_time']).' 取消关注'; ?></td>
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['subscribe_time']);?></td>
				<td class="center">
					<?php if($item['qrcode_time']+(30*24*3600) >time() || $item['qrcode_type']==0){?>
					<img src="<?php echo $item['qrcode_img'];?>" width="30px;" height="30px"/>
					<?php }else{ echo "<font color='red'>二维码已过期</font>";}?>
				</td>
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('revert_msg')){?>
					<a title="会话" style="color: blue;" target="dialog" mask="true" class="btnAssign infoBtn" rel="revert_msg"  width="700" height="500" href="/admin/WechatMessage/revert_msg?openid=<?php echo $item['openid'];?>">编辑</a>&nbsp&nbsp
						<?php if($item['no_read_msg']>0){?>
							<a class="msg_notice" id="<?php echo $item['openid'];?>"><?php echo $item['no_read_msg']?></a>
						<?php }?>
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
