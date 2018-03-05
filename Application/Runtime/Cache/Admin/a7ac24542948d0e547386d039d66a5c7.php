<?php if (!defined('THINK_PATH')) exit();?>
<div class="pageContent">
	
	<form method="post" action="/Course/edit_course?id=<?php echo I('get.id',0,'intval');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>上级课程：</label>
				<select name="fid" id="parent_course">
					<option value="0">请选择</option>
  					<option value="-1" <?php echo $info['fid']==0 ? 'selected' : '';?>>一级课程</option>
  					<?php foreach($lists as $items){?>
  						<option  <?php echo $info['fid']==$items['id'] ? 'selected' : '' ;?> value="<?php echo $items['id'];?>" <?php echo $items['fid']!=0 ? 'disabled' : '';?>><?php echo $items['html'].$items['name'];?></option>
  					<?php }?>
   				</select>
			</div>
			<div class="unit">
				<label>课程名称：</label>
				<input type="text" name="name" size="30" value="<?php echo $info['name'];?>"  minlength="2" placeholder="请输入名称" maxlength="20" class="required" />
			</div>
			<?php if($info['fid']==0){?>
			<div class="unit add_img">
				<label id="imglabel">展示图片</label>
				<dd>
					<div style="margin-left:2px;">
						<span id="uploadify_img" type="image">
							<img  src="<?php echo $info['img'];?>" width="60" />
							<input type="hidden" value="<?php echo $info['img'];?>" name="img" />
						</span>
					</div>
					<div style="float:left;margin-top:4px;">
							<input id="file" type="file" class="textInput" name="file" 
							uploaderOption="{
								swf:'/Static/plugins/Jui/uploadify/scripts/uploadify.swf',
								uploader:'/Upload',
								formData:{PHPSESSID:'xxx', ajax:1},
								buttonText:'请选择文件',
								fileSizeLimit:'5120KB',
								fileTypeDesc:'*.jpg;*.jpeg;*.gif;*.png;*.mp3;*.wma;*.wav;*.amr;*.mp4',
								fileTypeExts:'*.jpg;*.jpeg;*.gif;*.png;*.mp3;*.wma;*.wav;*.amr;*.mp4',
								auto:true,
								multi:false,
								onUploadError:uploadifyError,
								onUploadSuccess:uploadifySuccess,
								onQueueComplete:uploadifyQueueComplete
							}"/>
					</div>
				</dd>
			</div>
			<?php }?>
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
			var html = '<img src="'+data.url+'" width="60" /><input type="hidden" name="img" value="'+data.url+'"/>';
			$('#uploadify_img').html(html);
		}else{
			alert('上传失败，请重试！');
		}
	}

	$('#parent_course').change(function(){
		var val = $(this).val();
		if(val!=-1){
			$('.add_img').hide();
		}else{
			$('.add_img').show();
		}
	});
</script>