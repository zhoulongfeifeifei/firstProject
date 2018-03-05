
<div class="pageContent">
	
	<form method="post" action="/admin/Category/add_category" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>上级分类</label>
				<input type="hidden" name="fid" value="<?php echo I('get.fid',0,'intval');?>"/>
				<input type="text" readonly size="16" value="<?php echo I('get.fname','一级分类','trim');?>"/>
			</div>
			<div class="unit">
				<label>分类名：</label>
				<input type="text" name="name" size="30" minlength="2" placeholder="请输入名称" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>状态：</label>
				<label><input type="radio" name="status" value="1"/>上线</label>
				<label><input type="radio" name="status" value="0" checked/>下线</label>
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