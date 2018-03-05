
<div class="pageContent">
	
	<form method="post" action="/admin/System/edit_department?did=<?php echo I('get.did',0);?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">

			<div class="unit">
				<label>部门名称：</label>
				<input type="text" name="name" size="30" minlength="2" placeholder="请输入名称" maxlength="20" class="required" value="<?php echo $info['name'];?>"/>
			</div>
			<?php if(checkPermission('add_department_permission')){?>
			<div class="unit">
				<label>部门权限：</label>
				<?php foreach(C('menu') as $items){?>
					<div class="unit">
						<label>&nbsp</label>
						<label><input type="checkbox" <?php echo in_array($items['rel'],$info['permission']) ? 'checked' :'';?> name="permission[]" class="first_menu" value="<?php echo $items['rel'];?>"/><?php echo $items['name'];?></label>
						<div class="unit">
						<?php foreach($items['lists'] as $key=>$value){?>
							<?php if($key%4==0){
								echo "<label>&nbsp</label><label>&nbsp</label>";
							}?>
							<label><input type="checkbox" <?php echo in_array($value['rel'],$info['permission']) ? 'checked' :'';?> name="permission[]" class="sec_menu"  value="<?php echo $value['rel'];?>"/><?php echo $value['name'];?></label>
						<?php }?>
						</div>
					</div>
				<?php }?>
			</div>
			<?php }?>
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
	$('.sec_menu').click(function(){
		var _this = $(this);
		if(_this.attr('checked')){
			_this.parent().parent().parent().find('.first_menu').attr('checked',true);
		}
	});
</script>