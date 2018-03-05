<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="/WechatMessage/index">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<div class="pageHeader">
	<form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/WechatMessage/index" method="post">
	<div class="searchBar">
	 
		<ul class="searchContent">
			<li>
				
			</li>
			<li style="width:200px;"><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
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
				<th class="center" width="8%">来源</th>
				<th class="center" width="12%">类型</th>
				<th class="center" >消息内容</th>
				<th class="center" width="15%">发送时间</th>
			<!--	<th class="center" width="8%" nowrap="nowrap">操作</th>-->
			</tr>
		</thead>
		<tbody>
			<?php foreach ($result as $item){?>
			<tr target="sid_user" rel="<?php echo $item['id'];?>">
				<td>
					<input name="gids" value="<?php echo $item['id']?>" type="checkbox">
				</td>
				<td class="center"><?php echo $item['id']?></td>
				<td class="center">
					<p style="line-height:13px;"><?php echo $item['fromname'];?></p>
					<?php if($item['fromimg']){ echo '<img src="'.$item['fromimg'].'"  width="25px" height="25px"/>';}?>
				</td>
				<?php  switch($item['type']){ case 1: $str= '文本'; $content = replaceEmoji($item['content']); break; case 2: $str= '图片'; $content = '<img src="'.trim($item['medialoc']).'" height="180px"/>'; break; case 3: $str= '语音'; $content = '<audio controls="controls"><source src="'.$item['medialoc'].'" />无法播放</audio>'; break; case 4: $str= '视频'; $content = '<video src="'.$item['medialoc'].'" controls="controls" width="240px">加载失败或者资源错误</video>'; break; case 5: $str= '小视频'; $content = '<video src="'.$item['medialoc'].'" controls="controls" width="240px">加载失败或者资源错误</video>'; break; case 6: $str= '地理位置'; $content = '地址：'.$item['content']; break; case 7: $str= '链接'; $content = '<a href="'.$item['content'].'" target="_blank"><p sytle="font-size:14px;line-height:20px;">'.$item['Title'].'</p><p>'.$item['Description'].'</p></a>'; break; } echo '<td class="center">'.$str.'</td>'; echo '<td class="center">'.$content.'</td>'; ?>
				
				<td class="center"><?php echo date('Y-m-d H:i:s',$item['create_time']);?></td>
				<!--
				<td class="center" nowrap="nowrap">
					<?php if(checkPermission('del_receive_msg')){?>
					<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/WechatMessage/del_receive_msg?id=<?php echo $item['id'];?>">删除</a>
					<?php }?>
				</td>
				-->
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