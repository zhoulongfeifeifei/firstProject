
<div class="pageContent">
	
	<form method="post" action="/admin/Agency/edit_agency?id=<?php echo $info['id'];?>" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42">
			<div class="unit">
				<label>机构名称：</label>
				<input type="text"  value="<?php echo $info['name'];?>" name="name" size="30" minlength="2" placeholder="请输入名称" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>机构老板：</label>
				<select name="boss">
					<option value="0" <?php echo $info['boss']==0 ? 'selected' : '';?>>无</option>
					<?php foreach($boss_lists as $v){?>
						<option value="<?php echo $v['id'];?>" <?php echo $info['boss']==$v['id'] ? 'selected' : '';?>><?php echo $v['name'];?></option>
					<?php }?>
				</select>
			</div>
			<div class="unit">
				<label>前台：</label>
				<select name="reception">
					<option value="0" <?php echo $info['reception']==0 ? 'selected' : '';?>>无</option>
					<?php foreach($recep_lists as $v){?>
						<option value="<?php echo $v['id'];?>" <?php echo $info['reception']==$v['id'] ? 'selected' : '';?>><?php echo $v['name'];?></option>
					<?php }?>
				</select>
			</div>
			<div class="unit">
				<label>机构ID：</label>
				<input type="text" name="ag_id"  value="<?php echo $info['ag_id'];?>" size="20" minlength="2" placeholder="请输入ID" maxlength="20" class="required" />
			</div>
			<div class="unit">
				<label>开课时间：</label>
				<input type="text" name="start_time"  value="<?php echo date('H:i',strtotime('2016-01-01')+$info['start_time']);?>" class="date" dateFmt="HH:mm" readonly="true" /><a class="inputDateButton" href="javascript:;">选择</a>
			</div>
			<div class="unit">
				<label>结课时间：</label>
				<input type="text" name="end_time"  value="<?php echo date('H:i',strtotime('2016-01-01')+$info['end_time']);?>" class="date" dateFmt="HH:mm" readonly="true" /><a class="inputDateButton" href="javascript:;">选择</a>
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

</script>