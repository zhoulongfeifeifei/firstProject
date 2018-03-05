
<div class="pageContent">
	
	<form method="post" action="/admin/Users/add_users" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>用户名称：</label>
				<input type="text" name="name" size="30" minlength="2" placeholder="请输入名称" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>电话：</label>
				<input type="text" name="mobile" size="30" minlength="2" placeholder="请输入电话" maxlength="20" class="required tel" />
			</div>
			<div class="unit">
				<label>性别：</label>
				<select name="sex">
					<option value="0">请选择</option>
					<option value="1">男</option>
					<option value="2">女</option>
				</select>
			</div>
			<div class="unit">
				<label>用户类型：</label>
				<select name="type">
					<option value="0">请选择</option>
					<option value="1">学生</option>
					<option value="2">前台</option>
					<option value="3">老师</option>
					<option value="4">老板</option>
				</select>
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
	function uploadifyError(file,errorCode,errorMsg,errorString,swfuploadifyQueue){
		alert( 'id: ' + file.id
		　　+ ' - 索引: ' + file.index
		　　+ ' - 文件名: ' + file.name
		　　+ ' - 文件大小: ' + file.size
		　　+ ' - 类型: ' + file.type
		　　+ ' - 创建日期: ' + file.creationdate
		　　+ ' - 修改日期: ' + file.modificationdate
		　　+ ' - 文件状态: ' + file.filestatus
		　　+ ' - 错误代码: ' + errorCode
		　　+ ' - 错误描述: ' + errorMsg
		　　+ ' - 简要错误描述: ' + errorString
		　　+ ' - 出错的文件数: ' + swfuploadifyQueue.filesErrored
		　　+ ' - 错误信息: ' + swfuploadifyQueue.errorMsg
		　　+ ' - 要添加至队列的数量: ' + swfuploadifyQueue.filesSelected
		　　+ ' - 添加至对立的数量: ' + swfuploadifyQueue.filesQueued
		　　+ ' - 队列长度: ' + swfuploadifyQueue.queueLength);
	}

	function uploadifySuccess(file,data,response){
		data = eval('(' + data + ')');
		if(data.statusCode==200){
			$('#uploadify_img').html('<img src="'+data.url+'" width="220" /><input type="hidden" name="img" value="'+data.url+'"/>');
		}else{
			alert('上传失败，请重试！');
		}
	}
</script>