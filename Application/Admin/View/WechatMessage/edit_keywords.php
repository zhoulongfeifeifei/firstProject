
<div class="pageContent">
	
	<form method="post" action="/admin/WechatMessage/edit_keywords?id=<?php echo $info['id'];?>." class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>关键词：</label>
				<input type="text" name="words" size="20" minlength="1" placeholder="请输入关键词" maxlength="50" class="required" value="<?php echo $info['words'];?>"/>
			</div>
			<div class="unit">
				<label>状态：</label>
				
				<label><input type="radio" name="status" value="1" <?php echo $info['status']==1 ? 'checked' : '';?> />可用</label>
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