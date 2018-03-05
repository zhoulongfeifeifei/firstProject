
<div class="pageContent">
	
	<form method="post" action="/admin/Agency/add_agency_course?ag_id=<?php echo I('get.ag_id');?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>机构名称：</label>
				<input type="text" readonly  name="name" size="20"  value="<?php echo $agency['name'];?>" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>课程：</label>
				<select name="course_id" id="course_id">
					<option value="0">请选择</option>
					<?php foreach($course_lists as $v){?>
						<option <?php echo $v['sort']==1 ? '' : 'disabled';?> value="<?php echo $v['id'];?>"><?php echo $v['html'].$v['name'];?></option>
					<?php }?>
				</select>
			</div>
			<div class="unit">
				<label>教室数量：</label>
				<input type="text" name="classroom" size="16" value="1" minlength="1" placeholder="请输入教室数量 " maxlength="3" class="required number" />    
			</div>
			<div class="unit">
				<label>教室对应人数：</label>
				<input type="text" name="nums" size="16" value="1" minlength="1" placeholder="请输入人数 " maxlength="3" class="required number" />    
			</div>
			<div class="unit">
				<label>课程时长：</label>
				<input type="text" name="course_time" size="16" minlength="1" placeholder="请输入课程时长 " maxlength="20" class="required number" />    分钟
			</div>
			<div class="unit">
				<label>休息时间：</label>
				<input type="text" name="rest_time" size="16"  placeholder="请输入课程间隔时间" class="required number"/>       分钟
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
</script>