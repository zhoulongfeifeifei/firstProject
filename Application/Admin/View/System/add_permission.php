
<div class="pageContent">
	
	<form method="post" action="/admin/System/add_permission?id=<?php echo $employee_id;?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<?php if(checkPermission('add_employee_permission')){?>
			<div class="unit">
				<label><b>人员权限：</b></label>
				<?php foreach(C('permission') as $rel=>$items){?>
					<?php if(!in_array($rel,$department_permission)){ continue;}?>
					<div class="unit">
						<br />						
						<p><b><input type="checkbox" checked disabled /><?php echo $items['name'];?></b></p>
						<div class="unit">
						<?php $i=0; foreach($items['lists'] as $key=>$value){?>
							<?php if($i%4==0 || $i==0){
								echo "<label>&nbsp</label>";
							}?>
							
							<label><input type="checkbox" name="permission[]"  <?php echo in_array($key,$src_permission) ? 'checked' : '';?> value="<?php echo $key;?>"/><?php echo $value;?></label>
						<?php $i++;}?>
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

</script>