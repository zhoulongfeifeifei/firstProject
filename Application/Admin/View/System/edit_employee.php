
<div class="pageContent">
	
	<form method="post" action="/admin/System/edit_employee?id=<?php echo $employee_id;?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>部门</label>
				<select name="did" class="department">
  					<option value="0">请选择</option>
  					<?php foreach($department as $items){?>
  						<option value="<?php echo $items['id'];?>" <?php echo $info['did']==$items['id'] ? 'selected' : '';?>><?php echo $items['name'];?></option>
  					<?php }?>
   				</select>
			</div>
			<div class="unit">
				<label>是否部门主管：</label>
				<input type="checkbox" name="is_director" value="2" <?php echo $info['is_director'] ==2 ? 'checked':'' ;?> />
			</div>
			<div class="unit">
				<label>上级</label>
				<select name="fid" class="fid">
					<option value="0">请选择</option>
					<?php foreach($employee as $k=>$v){?>
  						<option value="<?php echo $v['id']?>" <?php echo $info['fid']==$v['id'] ? 'selected' : '';?>><?php echo $v['html'].$v['name'];?></option>
  					<?php }?>
   				</select>
			</div>
			<div class="unit">
				<label>人员帐号：</label>
				<input type="text" name="account" size="30" minlength="2" value="<?php echo $info['account'];?>" placeholder="请输入帐号" maxlength="20" class="required" readonly />
			</div>
			<div class="unit">
				<label>人员名称：</label>
				<input type="text" name="name" size="30" minlength="2" value="<?php echo $info['name'];?>" placeholder="请输入名称" maxlength="20" class="required" readonly/>
			</div>
			<div class="unit">
				<label>密码：</label>
				<input type="password" name="passwd" size="30" minlength="2"  placeholder="输入密码即可修改" maxlength="20"  />
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
	$('.department').change(function(){
		var did = $(this).val();
		$.ajax({
			type: "POST",
			url: '/admin/System/get_employee_bydid',
			data: {did:did},
			dataType: "json",
			success: function(data){
				if(data){
					var html = '<option value="0">请选择</option>';
					$(data).each(function(i,v){
						html+='<option value="'+v.id+'">'+v.html+v.name+'</option>';
					});
					$('.fid').html(html);
				}
			}
		});
	});
</script>