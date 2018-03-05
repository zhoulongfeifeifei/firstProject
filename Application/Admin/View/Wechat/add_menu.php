
<div class="pageContent">
	
	<form method="post" action="/admin/Wechat/add_menu" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>上级菜单：</label>
				<select name="fid" class="fid">
  					<option value="0">一级菜单</option>
  					<?php foreach($menu as $items){?>
  						<option value="<?php echo $items['menu_id'];?>"><?php echo $items['menu_name'];?></option>
  					<?php }?>
   				</select>
			</div>
			<div class="unit">
				<label>菜单名称：</label>
				<input type="text" id="menu_name" name="menu_name" size="12" minlength="1" placeholder="请输入名称" maxlength="12" class="required" />
			</div>
			<div class="unit">
				<label>排序：</label>
				<input type="text"  name="sort" size="8" minlength="1" maxlength="4" value="0" />
			</div>
			<div class="unit">
				<label>菜单类型：</label>
				<select name="type">
  					<option value="0">请选择</option>
  					<option value="1">点击</option>
  					<option value="2">url跳转</option>
   				</select>
			</div>
			<div class="unit">
				<label>菜单key/url</label>
				<input type="text" name="menu_content" size="30" minlength="1" placeholder="请输入类型对应内容" maxlength="500" class="required" />
			</div>
			<div class="unit">
				<label>状态：</label>
				<label><input type="radio" name="status" value="1"/>可用</label>
				<label><input type="radio" name="status" value="0" checked/>禁用</label>
			</div>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
	
</div>

<script type="text/javascript">
	$('.fid').change(function(){
		if($(this).val()!=0){
			$('#menu_name').attr('maxlength',21);
		}
	});
</script>