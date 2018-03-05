
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
			<div class="unit">
				<span style="color:red">*注释：老师／学生／课程 对应是机构下关联信息。若无信息，可前往----机构列表---中去关联相关信息</span>
			</div>		
		</div>
		<div class="pageFormContent" layoutH="42" style="width:50%;float:left">
			<h1>step2 添加课时</h1>
			<h1 class="errormsg" style="color:red;height:28px;line-height:28px;">请选择左边信息</h1>
			<div class="unit">
				<label>选择日期：</label>
				<input type="text" name="select_time" id="select_time" value="<?php echo date('Y-m-d');?>" class="date"  dateFmt="yyyy-MM-dd"  readonly="true" /><a class="inputDateButton" href="javascript:;">选择</a>
				<input type="button" value="查询课表" id="search_timetable" style="height:30px;background:red;color:#fff;"/>
			</div>	
			<div class="unit">
				<ul class="weektime">
					<li class="daytime">
						<ul class="dayweek">
							
						</ul>
					</li>
				</ul>
			</div>	
			<div class="unit">
				<label>总课时：</label>
				<input type="text" size="8" minlength="1" maxlength="3" value="1" placeholder="课时" class="required number"/>
			</div>	
			<div class="unit">
				<label>第一次课程时间：</label>
				<input type="text" name="start_time" class="date"  dateFmt="yyyy-MM-dd HH:mm"  readonly="true" /><a class="inputDateButton" href="javascript:;">选择</a>
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
<style type="text/css">
	.weektime{
		overflow:auto;
		height:200px;
		background:rgba(245,245,245,0.9);
	}
	.weektime>li{
		float: left;
	}
	.daytime{
		width:1750px; 
		height:30px;
		border:1px solid rgba(240,240,240,0.9);
	}
	.dayline{
		width:1750px; 
		height:80px;
		margin-top:2px;
		border:1px solid rgba(240,240,240,0.9);
	}
	.dayweek,.daycourse{
		width:100%;
	}
	.dayweek>li{
		float: left;
		width:100px;
		height:28px;
		line-height: 28px;
		font-size:13px;
		background:rgb(235,235,235);
		border-left:1px solid rgb(200,200,200);
		border-bottom:1px solid rgb(200,200,200);
		text-align: left;
	}
	.daycourse>li{
		float: left;
		width:100px;
		height:80px;
		line-height: 80px;
		font-size:13px;
		border-left:1px solid rgb(200,200,200);
		border-bottom:1px solid rgb(200,200,200);
		text-align: center;
	}
	.daycourse>li>p{
		width:90px;
		height:16px;
		margin:0 auto;
		text-align: center;
		line-height: 26px;
		font-size: 13px;
	}
	.choosecourse{
		background:#b3e4eb;
	}
</style>

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
					get_course_table();
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
							html+='<option value="'+v.id+'" disabled>'+v.name+'</option>';
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

	$('#search_timetable').click(function(){
		get_course_table();
	});

	//获取老师机构课表
	function get_course_table(){
		var ag_id = $('#search_agency_lists').val();
		var teacher_id = $('#teacher_lists').val();
		var select_time = $('#select_time').val();
		var course_id = $('#course_lists').val();
		var errorMsg = '请选择机构获取老师！';

		if(ag_id<=0 || teacher_id<=0){
			$('.errormsg').text(errorMsg);
		}else{
			$('.errormsg').text('');
			$.ajax({
				type: "POST",
				url: '/admin/Course/get_teacher_course',
				data: {ag_id:ag_id,teacher_id:teacher_id,course_id:course_id,select_time:select_time},
				dataType: "json",
				success: function(data){
					var time_line = data.time_line;
					var time_html = '<li>日期</li>';
					$(time_line).each(function(i,v){
						time_html+='<li>'+v+'</li>';
					});
					$('.dayweek').html(time_html);
					var course_lists = data.course_lists;
					var course_html = '';
					$('.dayline').remove();
					$(course_lists).each(function(i,v){
						course_html+='<li class="dayline"><ul class="daycourse">';
						course_html+='<li>'+data.select_time[i]+'</li>';
						$(v).each(function(m,n){
							var content = '';
							if(n.id>0){
								content+= '<p>'+n.course_name+'</p>';
								content+= '<p>'+n.teacher_name+'</p>';
							}
							course_html+='<li>'+content+'</li>';
						});
						course_html+='</ul></li>';
					});
					console.log(course_html);
					$('.weektime').append(course_html);
				}
			});
		}	
	}

</script>