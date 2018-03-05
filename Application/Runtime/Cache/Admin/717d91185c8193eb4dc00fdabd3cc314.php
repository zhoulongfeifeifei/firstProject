<?php if (!defined('THINK_PATH')) exit();?>
<div class="pageContent">
	
	<form method="post" action="/admin/Agency/add_agency_users?ag_id=<?php echo I('get.ag_id');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>机构名称：</label>
				<input type="text" readonly  name="name" size="20"  value="<?php echo $agency['name'];?>" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>用户搜索：</label>
				<input type="search" id="search" placeholder="请输入用户姓名" style="padding:10px;"/>
			</div>
			<div class="unit">
				<label>选择用户：</label>
				<select name="user_id" id="search_res">
					<option value="0">请选择</option>
				</select>
			</div>
			<div class="unit">
				<label>预留电话1：</label>
				<input type="text" name="mobile" id="remark_mobile" size="16" minlength="1" placeholder="请输入预留电话 " maxlength="20" class="required number" />  
			</div>
			<div class="unit">
				<label>预留电话2：</label>
				<input type="text" name="tel_phone" size="16" minlength="1" placeholder="请输入预留电话 " maxlength="20" class=" " />  
			</div>
			<div class="unit">
				<label>备注：</label>
				<input type="text" name="remark" size="30"  placeholder="请输入备注信息" class=""/>     
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
	$('#search').bind('input',function(){
		var keyword = $(this).val();
		search_users(keyword);
	});

	function search_users(name){
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/Agency/get_users_lists',
			data: {name:name},
			dataType: "json",
			success: function(data){
				var lists = data.lists;
				var html = '<option value="0">请选择</option>';
				if(lists.length>0){
					$(lists).each(function(i,v){
						var typename = '未知';
						if(v.type==1){
							typename='学生';
						}else if(v.type==2){
							typename = '前台';
						}else if(v.type==3){
							typename = '老师';
						}else if(v.type==4){
							typename = '老板';
						}
						html+='<option value="'+v.id+'">'+v.name+'（'+typename+'）</option>';
					});
				}else{
					var html = '<option value="0">未搜索到相应信息</option>';
				}
				$('#search_res').html(html);
			}
		});
	}

</script>