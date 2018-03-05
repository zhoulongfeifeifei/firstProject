
<div class="pageContent">
	
	<form method="post" action="/admin/Agency/edit_agency_users?ag_id=<?php echo I('get.ag_id');?>&id=<?php echo I('get.id');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>机构名称：</label>
				<input type="text" readonly  name="name" size="20"  value="<?php echo $agency['name'];?>" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>选择用户：</label>
				<select name="user_id" id="search_res">
					<option value="<?php echo $info['user_id'];?>" selected><?php echo $info['user_name'];?></option>
				</select>
			</div>
			<div class="unit">
				<label>预留电话1：</label>
				<input type="text" name="mobile"  value="<?php echo $info['mobile']?>" id="remark_mobile" size="16" minlength="1" placeholder="请输入预留电话 " maxlength="20" class="required number" />  
			</div>
			<div class="unit">
				<label>预留电话2：</label>
				<input type="text" name="tel_phone" value="<?php echo $info['tel_phone']?>" size="16" minlength="1" placeholder="请输入预留电话 " maxlength="20" class=" " />  
			</div>
			<div class="unit">
				<label>备注：</label>
				<input type="text" name="remark" size="30"  value="<?php echo $info['remark']?>" placeholder="请输入备注信息" class=""/>     
			</div>
			<div class="unit">
				<label>状态：</label>
				<label><input type="radio" name="status" value="1" <?php echo $info['status']==1 ? 'checked' : '';?>/>可用</label>
				<label><input type="radio" name="status" value="0" <?php echo $info['status']==0 ? 'checked' : '';?>/>禁用</label>
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


</script>