
<div class="pageContent">
	
	<form method="post" action="/admin/Subject/edit_subject?id=<?php echo I('get.id',0,'intval');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>学科名称：</label>
				<input type="text" name="name" size="30" value="<?php echo $info['name'];?>"  minlength="2" placeholder="请输入名称" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>状态：</label>
				<label><input type="radio" name="status" value="1" <?php echo $info['status']==1 ? 'checked' : '';?>/>上线</label>
				<label><input type="radio" name="status" value="0" <?php echo $info['status']==0 ? 'checked' : '';?>/>下线</label>
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