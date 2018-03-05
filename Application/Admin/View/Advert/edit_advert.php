
<div class="pageContent">
	
	<form method="post" action="/admin/Advert/edit_advert?id=<?php echo $info['id'];?>&rel=<?php echo I('get.rel','','trim');?>&type=<?php echo I('get.type',0,'intval');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>广告名称：</label>
				<input type="text" name="name"  value="<?php echo $info['name'];?>" size="30" minlength="2" placeholder="请输入名称" maxlength="100" class="required" />
			</div>
			<div class="unit">
				<label>排序值：</label>
				<input type="text" name="sort" value="<?php echo $info['sort'];?>" size="20" minlength="1" placeholder="请输入数字" maxlength="10" value="0" class="required" />
			</div>
			<div class="unit">
				<label>广告类型：</label>
				<select name="skip_type">
					<option value="0" <?php echo $info['skip_type']==0 ? 'selected' : '';?>>请选择</option>
					<option value="3" <?php echo $info['skip_type']==1 ? 'selected' : '';?>>url</option>
				</select>
			</div>
			<div class="unit">
				<label>广告类型URL：</label>
				<input type="text" size="30"  value="<?php echo $info['skip_content'];?>" name="skip_content" placeholder="请输入url" class="required" minlength="1" maxlength="200" />
			</div>
			<div class="unit">
				<label>广告描述：</label>
				<textarea name="desc" cols="50" rows="3" placeholder="请输入描述"><?php echo $info['desc'];?></textarea>
			</div>
			<div class="unit">
				<label>封面图：</label>
				<dd>
					<div style="margin-left:2px;">
						<span id="uploadify_img">
							<img src="<?php echo $info['img'].'.'.$info['ext'];?>" width="160"/>
							<input type="hidden" name="img" value="1" />
						</span>
					</div>
					<div style="float:left;margin-top:4px;">
							<input id="file" type="file" class="textInput" name="file" 
							uploaderOption="{
								swf:'/Static/plugins/Jui/uploadify/scripts/uploadify.swf',
								uploader:'/admin/Upload',
								formData:{PHPSESSID:'xxx', ajax:1},
								buttonText:'请选择文件',
								fileSizeLimit:'2048KB',
								fileTypeDesc:'*.jpg;*.jpeg;*.gif;*.png;',
								fileTypeExts:'*.jpg;*.jpeg;*.gif;*.png;',
								auto:true,
								multi:false,
								onUploadError:uploadifyError,
								onUploadSuccess:uploadifySuccess,
								onQueueComplete:uploadifyQueueComplete
							}"/>
					</div>
				</dd>
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
			$('#uploadify_img').html('<img src="'+data.url+'" width="160" /><input type="hidden" name="img" value="'+data.url+'"/>');
		}else{
			alert('上传失败，请重试！');
		}
	}
</script>