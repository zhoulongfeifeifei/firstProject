
<div class="pageContent">
	
	<form method="post" action="/admin/WechatMessage/add_revert" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>消息类型：</label>
				<select name="type" class="type">
  					<option value="-1">请选择</option>
  					<option value="1">关注</option>
  					<option value="0">关键词（文本）</option>
  					<option value="2">图片</option>
  					<option value="3">语音</option>
  					<option value="4">视频</option>
  					<option value="5">小视频</option>
  					<option value="6">地理位置</option>
  					<option value="7">链接</option>
   				</select>
			</div>
			<div class="unit">
				<label>名称：</label>
				<input type="text" name="name" size="20" minlength="1" placeholder="请输入名称" maxlength="50" class="required" />
			</div>
			<div class="unit" id="keywords">
				<label>选择关键词：</label>
				<?php $i=1; foreach($keywords as $key=>$value){?>
					<?php if($i%6==0 ){
						echo "<label>&nbsp</label>";
					}?>
					<label><input type="checkbox" name="keywords[]" value="<?php echo $value['id'];?>"/><?php echo $value['words'];?></label>
				<?php $i++;}?>
			</div>
			<input type="hidden" name="material_id" id="material_id"/>
			<div class="unit" id="material">
				<label>回复内容(素材)：</label>
				<select name="materialType" id="materialType">
  					<option value="1">文本</option>
  					<option value="2">图片</option>
  					<option value="3">语音</option>
  					<option value="4">视频</option>
  					<option value="5">音乐</option>
  					<option value="6">图文</option>
   				</select>&nbsp&nbsp&nbsp&nbsp
				<input type="text" id="searchinput" placeholder="请输入素材名称" size="20" />
				<input type="button" value="搜索" id="searchMaterial" />
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
	searchBar();
	$('#keywords').hide();
	$('.type').change(function(){
		var val = $(this).val();
		if(val==0){
			$('#keywords').show();
		}else{
			$('#keywords').hide();
		}
	});
	function searchBar(){
		$('#searchMaterial').click(function(){
			var searchval = $('#searchinput').val();
			var type = $('#materialType').val();
			ajax_material(1,searchval,type);
		});
	}

	function ajax_material(page,search,type){
		var html = '<label>回复内容(素材)：</label>';
		var page = parseInt(page);
		//禁止加载
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/WechatMaterial/get_material?type='+type+'&page='+page,
			data: {name:search},
			dataType: "json",
			success: function(data){
				html+='<input type="text" id="searchinput" placeholder="请输入素材名称" size="20" value="'+(data.search ? data.search : '')+'"/>&nbsp&nbsp&nbsp&nbsp';
				html+='<select name="materialType" id="materialType">\
	  					<option value="1" '+(data.type==1 ? 'selected' : '')+'>文本</option>\
	  					<option value="2" '+(data.type==2 ? 'selected' : '')+'>图片</option>\
	  					<option value="3" '+(data.type==3 ? 'selected' : '')+'>语音</option>\
	  					<option value="4" '+(data.type==4 ? 'selected' : '')+'>视频</option>\
	  					<option value="5" '+(data.type==5 ? 'selected' : '')+'>音乐</option>\
	  					<option value="6" '+(data.type==6 ? 'selected' : '')+'>图文</option>\
	   				</select>';
				html+='<input type="button" value="搜索" id="searchMaterial" />';
				if(data.status){
					var node_li = '';
					$(data.lists).each(function(i,v){
						node_li+='<li><input type="checkbox" class="selected_material" value="0"/><input type="hidden" class="chooseval" value="'+v.id+'" />';
						switch(data.type){
							case 1:
								node_li+=''+v.name+'<span class="img_text">'+v.content+'</span></li>';
								break;
							case 2:
								node_li+=''+v.name+'<img src="'+v.contenturl+'" /></li>';
								break;
							case 3:
								node_li+='<span>'+v.name+'</span><audio controls="controls"><source src="'+v.contenturl+'" />无法播放</audio></li>';
								break;
							case 4:
								node_li+='<span>'+v.name+'</span><video src="'+v.contenturl+'" controls="controls" >加载失败或者资源错误</video></li>';
								break;
							case 5:
								node_li+='<span class="img_text" >'+v.title+'</span><audio controls="controls"><source src="'+v.contenturl+'" />无法播放</audio></li>';
								break;
							case 6:
								node_li+='<span class="img_text" >'+v.title+'</span><a href="'+v.url+'" target="_blank"><img src="'+v.contenturl+'"  height="80px"/></a>';
								node_li+=' 排序：<input type="text" size="4" maxlength="4" value="0" name="material_sort['+v.id+']" /></li>';
								break;
						}
						
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
					$('#material').html(html);
					searchBar();

					$('.topage').click(function(){
						var searchval = $('#searchinput').val();
						var clickpage = $(this).attr('page');
						var selectType = $('#materialType').val();
						ajax_material(clickpage,searchval,selectType);
					});
					$('.selected_material').click(function(){
						var selectType = $('#materialType').val();
						var selectVal = '';
						var material_html= '';
						if(selectType!=6){
							$('.selected_material').attr('checked',false);
							$(this).attr('checked','checked');
							selectVal = $(this).parent().find('.chooseval').val();
							$('#material_id').val(selectVal);
						}else{
							var cnt = 0;
							$('.selected_material').each(function(i,v){
								var is_sel= $(v).attr('checked');
								if(is_sel){
									cnt++;
									selectVal+= $(v).parent().find('.chooseval').val()+',';
								}
							});
							if(cnt>7){
								alert('图文最多7个！');
							}
							$('#material_id').val(selectVal);
						}
					});	
				}else{
					html+= '<font color="red">没有素材</font>';
					$('#material').html(html);
					searchBar();
				}
			}
		});
	}
</script>