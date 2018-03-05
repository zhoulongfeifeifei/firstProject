
<div class="pageContent">
	
	<form method="post" action="/admin/WechatMaterial/add_material" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>素材类型：</label>
				<select name="type" class="type">
  					<option value="1">文本</option>
  					<option value="2">图片</option>
  					<option value="3">语音</option>
  					<option value="4">视频</option>
  					<option value="5">音乐</option>
  					<option value="6">图文</option>
   				</select>
			</div>
			<div class="unit">
				<label>名称：</label>
				<input type="text"  name="name" size="25" minlength="1" placeholder="请输入名称" maxlength="40" class="required" />
			</div>
			<div class="unit other_show">
				<label>标题：</label>
				<input type="text"  name="title" size="25" minlength="1" placeholder="请输入标题" maxlength="100" />
			</div>
			<div class="unit other_show">
				<label>描述：</label>
				<textarea name="description" cols="50" rows="4" placeholder="请输入描述"></textarea>>
			</div>
			<div class="unit add_img">
				<label id="imglabel">上传图片</label>
				<dd>
					<div style="margin-left:2px;">
						<span id="uploadify_img" type="image">
						</span>
					</div>
					<div style="float:left;margin-top:4px;">
							<input id="file" type="file" class="textInput" name="file" 
							uploaderOption="{
								swf:'/Static/plugins/Jui/uploadify/scripts/uploadify.swf',
								uploader:'/admin/Upload',
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
			<div class="unit" id="imgUrlType">
				<label>图片链接类型：</label>
				<select class="imgTypeSel">
  					<option value="1">输入链接</option>
  					<option value="2">素材图片</option>
   				</select>
			</div>
			<div class="unit" id="imgMaterial">
				<label>&nbsp</label>
				<input type="text"  placeholder="请输入素材名称" size="20" />
				<input type="button" value="搜索" id="searchMaterial" />
			</div>
			<div class="unit img_text">
				<label id="link">图片链接</label>
				<input type="text"  name="contenturl" size="40" minlength="1" placeholder="请输入链接" maxlength="200" />
			</div>
			<div class="unit other_show">
				<label id="other_link">链接</label>
				<input type="text"  name="url" size="40" minlength="1" placeholder="请输入链接" maxlength="200" />
			</div>
			<div class="unit text_show">
				<label>内容：</label>
				<textarea name="content" cols="50" rows="4" placeholder="请输入文本"></textarea>
			</div>
			<div class="unit">
				<label>状态：</label>
				<label><input type="radio" name="status" value="1"/>可用</label>
				<label><input type="radio" name="status" value="0" checked/>禁用</label>
			</div>
			<div class="unit">
				<label>&nbsp</label>
				<font color="red">注：可用  图片／语音／视频将会上传微信临时素材（有效期3天） 其他为本地永久素材</font>
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
	$('.other_show').hide();
	$('.img_text').hide();
	$('.add_img').hide();
	$('#imgUrlType').hide();
	$('#imgMaterial').hide();


	$('.type').change(function(){
		var value = $(this).val();
		$('#imgUrlType').hide();
		$('#imgMaterial').hide();
		$('#chooseimg').remove();
		if($(this).val()==1){
			$('.text_show').show();
			$('.other_show').hide();
			$('.img_text').hide();
			$('.add_img').hide();
		}else{
			$('.text_show').hide();
			$('.other_show').show();
			if(value==6){
				$('#link').html('图片链接：');
				$('.img_text').show();
				$('#other_link').html('文章链接：');
				$('#imgUrlType').show();
				var imgurl = '&nbsp&nbsp&nbsp&nbsp<img id="chooseimg" src="" height="60px;"/>';
				$('.img_text').append(imgurl);
			}else{
				$('.img_text').hide();
				if(value==5){
					$('.add_img').hide();
					$('#link').html('音乐链接：');
					$('#other_link').html('高质量url：');
					$('.img_text').show();
				}else if(value==2){
					$('.add_img').show();
					$('#imglabel').text('上传图片：');
					$('#uploadify_img').attr('type','image');
					$('.other_show').hide();
				}else if(value==3){
					$('.add_img').show();
					$('#imglabel').text('上传语音：');
					$('#uploadify_img').attr('type','voice');
					$('#other_link').parent().hide();
					$('.other_show').hide();
				}else if(value==4){
					$('.add_img').show();
					$('#imglabel').text('上传视频：');
					$('#uploadify_img').attr('type','video');
					$('.other_show').show();
					$('#other_link').parent().hide();
				}
			}
		}
	});

	$('.img_text').find('input').blur(function(){
		if($('#chooseimg')){
			$('#chooseimg').attr('src',$(this).val());
		}
	});

	//监测图片链接
	$('.imgTypeSel').change(function(){
		var val = $(this).val();
		if(val==1){
			$('.img_text').find('input').removeAttr('readonly');
			$('.img_text').find('input').css('background','');
			$('#imgMaterial').hide();
			$('.img_text').find('input').val('');
		}else{
			$('.img_text').find('input').attr('readonly','readonly');
			$('.img_text').find('input').css('background','#ccc');
			$('#imgMaterial').show();
			var page = 1;
			ajax_material(page);
		}
	});

	function ajax_material(page,search){
		//禁止加载
		$.ajaxSettings.global=false; 
		var html = '<label>&nbsp</label>';
		$.ajax({
			type: "POST",
			url: '/admin/WechatMaterial/get_material?type=2&page='+page,
			data: {name:search},
			dataType: "json",
			success: function(data){
				html+='<input type="text" id="searchinput" placeholder="请输入素材名称" size="20" value="'+(data.search ? data.search : '')+'"/>';
				html+='<input type="button" value="搜索" id="searchMaterial" />';
				if(data.status){
					var node_li = '';
					$(data.lists).each(function(i,v){
						node_li+='<li><input type="checkbox" class="secect_img_material" value="0"/>'+v.name+'<img src="'+v.contenturl+'" /></li>'
					});
					var perpage = '';
					var nextpage = '';
					if(page>1){
						perpage = '<div class="topage" page="'+(page-1)+'"><</div>';
					}
					if(!data.last_page){
						nextpage = '<div class="topage" page="'+(page+1)+'">></div>';
					}
					html+='<div class="unit">\
							<label>&nbsp</label>\
							<div>\
								<ul>'+perpage+node_li+nextpage+'</utl>\
							</div>\
						</div>';
					$('#imgMaterial').html(html);
					$('.img_text').find('input').val('');

					$('#searchMaterial').click(function(){
						var searchval = $('#searchinput').val();
						ajax_material(1,searchval);
					});

					$('.topage').click(function(){
						var searchval = $('#searchinput').val();
						var clickpage = $(this).attr('page');
						ajax_material(clickpage,searchval);
					});
					$('.secect_img_material').click(function(){
						$('.secect_img_material').attr('checked',false);
						$(this).attr('checked','checked');
						var url = $(this).parent().find('img').attr('src');
						$('.img_text').find('input').val(url);
						$('#chooseimg').attr('src',url);
					});	
				}else{
					html+= '<font color="red">没有图片素材</font>';
					$('#imgMaterial').html(html);
					$('#searchMaterial').click(function(){
						var searchval = $('#searchinput').val();
						ajax_material(1,searchval);
					});
				}
			}
		});
	}

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
			var type = $('#uploadify_img').attr('type');
			var html = '<img src="'+data.url+'" width="220" />';
			if(type=='voice'){
				html = '<audio controls="controls"><source src="'+data.url+'" />无法播放</audio>';
			}else if(type=='video'){
				html= '<video src="'+data.url+'" controls="controls" width="240px">加载失败或者资源错误</video>';
			}
			html+= '<input type="hidden" name="media" readonly value="'+data.url+'" />';
			$('#uploadify_img').html(html);
		}else{
			alert('上传失败，请重试！');
		}
	}
</script>