<?php if (!defined('THINK_PATH')) exit();?>
<div class="pageContent">
	
	<form method="post" action="/admin/Course/add_timetable" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone);">

		<div class="pageFormContent" layoutH="42" style="width:40%;float:left;border-right:1px solid #ccc;">
			<h1>step1 选择基础信息</h1>
			<div class="unit">
				<label>搜索机构：</label>
				<input  type="search" id="search_agency" placeholder="请输入机构关键词" style="padding:10px"/>
			</div>	
			<div class="unit">
				<label>&nbsp</label>
				<select name="ag_id" id="search_agency_lists">
					
				</select>
			</div>
			<div class="unit">
				<label>选择老师：</label>
				<select name="teacher_id" id="teacher_lists">
					
				</select>
			</div>	
			<div class="unit">
				<label>选择课程：</label>
				<select name="course_id" id="course_lists">
				</select>
			</div>	
			<div class="unit">
				<label>搜索学生：</label>
				<input  type="search" id="search_student" placeholder="请输入学生关键词" style="padding:10px"/>
			</div>	
			<div class="unit">
				<label>&nbsp</label>
				<select name="student_id" id="search_student_lists">
					
				</select>
			</div>			
		</div>
		<div class="pageFormContent" layoutH="42" style="width:50%;float:left">
			<h1>step1 选择基础信息</h1>
			<div class="unit">
				<label>搜索机构：</label>
				<input  type="search" id="search_agency" placeholder="请输入机构关键词" style="padding:10px"/>
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
	$('#search_agency').bind('input',function(){
		var keywords = $(this).val();
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/Agency/search_agency_lists',
			data: {name:keywords},
			dataType: "json",
			success: function(data){
				var lists = data.lists;
				var html = '<option value="0">请选择</option>';
				if(lists.length>0){
					$(lists).each(function(i,v){
						html+='<option value="'+v.id+'">'+v.name+'</option>';
					});
				}else{
					html = '<option value="0">未搜索到相应数据</option>';
				}
				$('#search_agency_lists').html(html);
				get_teacher_lists();
				get_course_lists();
			}
		});
	});

	$('#search_student').bind('input',function(){
		var keywords = $(this).val();
		var ag_id = $('#search_agency_lists').val();
		$.ajaxSettings.global=false; 
		$.ajax({
			type: "POST",
			url: '/admin/Users/get_agency_users_lists',
			data: {name:keywords,type:1,ag_id:ag_id},
			dataType: "json",
			success: function(data){
				var lists = data.lists;
				var html = '<option value="0">请选择</option>';
				if(lists.length>0){
					$(lists).each(function(i,v){
						html+='<option value="'+v.id+'">'+v.name+'</option>';
					});
				}else{
					html = '<option value="0">未搜索到相应数据</option>';
				}
				$('#search_student_lists').html(html);
			}
		});
	});

	function get_teacher_lists(){
		$('#search_agency_lists').change(function(){
			var ag_id = $(this).val();
			$.ajax({
				type: "POST",
				url: '/admin/Users/get_agency_users_lists',
				data: {ag_id:ag_id,type:3},
				dataType: "json",
				success: function(data){
					var lists = data.lists;
					var html = '<option value="0">请选择</option>';
					if(lists.length>0){
						$(lists).each(function(i,v){
							html+='<option value="'+v.id+'">'+v.name+'</option>';
						});
					}else{
						html = '<option value="0">该机构下没有老师！</option>';
					}
					$('#teacher_lists').html(html);
				}
			});
		});
	}
	function get_course_lists(){
		$('#search_agency_lists').change(function(){
			var ag_id = $(this).val();
			$.ajax({
				type: "POST",
				url: '/admin/Course/get_agency_course',
				data: {ag_id:ag_id,type:3},
				dataType: "json",
				success: function(data){
					var lists = data.lists;
					var html = '<option value="0">请选择</option>';
					if(lists.length>0){
						$(lists).each(function(i,v){
							html+='<option value="'+v.id+'">'+v.name+'</option>';
							$(v.child).each(function(m,n){
								html+='<option value="'+n.id+'">&nbsp&nbsp&nbsp'+n.name+'</option>';
							});
						});
					}else{
						html = '<option value="0">该机构下没有老师！</option>';
					}
					$('#course_lists').html(html);
				}
			});
		});
	}


</script>