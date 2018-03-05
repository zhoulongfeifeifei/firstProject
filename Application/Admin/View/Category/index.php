<form id="pagerForm" method="post" action="/admin/Category">
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $per_page; ?>" />
</form>
<style type="text/css">
	.cate_lists{
		width:100%;
		padding:20px 0 0 10px;
		height:100%;
		overflow: scroll;
	}

	.cate_lists label{
		float:left;
		height:21px;
		line-height: 21px;
	}
	.clearfloat{
		clear: both;
		list-style: none;
	}
	.cat_li{
		height:25px;
	}
	.none{
		display:none;
	}
	.is_red{
		color:red;
	}
	.first_cat{
		font-size: 16px;
		font-family:微软雅黑;
		font-weight: 800;
	}
	.cat_info{
		width:25%;
		float:left;
		height:250px;
		overflow: scroll;
		margin-bottom: 30px;
		border-top: 20px solid #e8edf3;
	}
</style>
<div class="pageContent">
<div layoutH="17">
	<div class="cate_lists">
			<ul>
			<li class="cat_li">
				<label class="cat_name">|--分类列表</label>
				<?php if(checkPermission('add_category')){?>
					<label><a class="btnAdd" href="/admin/Category/add_category?fid=0&fname=一级分类" target="dialog" width="600" height="250"mask="true" maxable="false" ></a></label>
				<?php }?>
				<span>备注：字体红色表示禁用状态</span>
			</li>
			</ul>
			<li class="clearfloat"></li>
			<?php foreach($lists as $k=>$item){?>
			<?php if($item['fid']==0){?>
				<?php if($k==0){?>
					<ul class="cat_info">
				<?php }else{?>
					</ul><ul class="cat_info">
				<?php }?>
			<?php }?>
			<?php if(count($lists)==$k-1){?>
				</ul>
			<?php }?>
			<li class="cat_li cat_li_<?php echo $item['fid']?> ">
				<label class="cat_name <?php echo $item['sort']==0 ? 'first_cat' : '';?> <?php echo $item['status']==0 ? "is_red" : '';?>" cat_id="<?php echo $item['id'];?>"><?php echo $item['html'].$item['html']?>|----<?php echo $item['name'];?></label>
				<label>
					<?php if(checkPermission('add_category') && $item['sort']<2){?>
						<a class="btnAdd" href="/admin/Category/add_category?fid=<?php echo $item['id']?>&fname=<?php echo $item['name']?>" target="dialog" width="600" height="250"mask="true" maxable="false" ></a>
					<?php }?>
					<?php if(checkPermission('edit_category')){?>
						<a title="编辑" style="color: blue;" target="dialog" mask="true" class="btnEdit" rel="edit_category"  width="600" height="250" href="/admin/Category/edit_category?id=<?php echo $item['id'];?>">编辑</a>&nbsp&nbsp
					<?php }?>
					<?php if(checkPermission('del_category')){?>
						<a title="删除" style="color:blue;" target="ajaxTodo" class="btnDel" href="/admin/Category/del_category?id=<?php echo $item['id'];?>">删除</a>
					<?php }?>
				</label>
			</li>
			<?php }?>
	</div>
</div>
</div>
<script type="text/javascript">
	$('.cat_name').click(function(){
		var cat_id = $(this).attr('cat_id');
		var next_node = $('.cat_li_'+cat_id);
		if(next_node.length>0){
			next_node.toggleClass('none');
			$(next_node).each(function(i,v){
				var is_node = $(v).hasClass('none');
				var next_cat_id = $(v).find('.cat_name').attr('cat_id');
				var th_node = $('.cat_li_'+next_cat_id);
				if(th_node.length>0){
					$(th_node).each(function(m,n){
						if(is_node){
							$(n).addClass('none');
						}
					});
				}
			});
		}
	});
</script>
