$(function(){

	var default_info = new Object();
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('课表');
		get_timetable_info();
		change_week_time();
	};

	//获取课表信息
	function get_timetable_info(ag_id,teacher_id,student_id,select_time){
		if(!ag_id){
			ag_id = $('#agency_lists').val();
		}
		if(!teacher_id){
			teacher_id = $('#teacher_lists').val();
		}
		if(!student_id){
			student_id = $('#student_lists').val();
		}
		$.ajax({
			url:apiUrl+'Course/get_course_lists',
			type: "POST",
			data:{openid:openid,ag_id:ag_id,teacher_id:teacher_id,student_id:student_id,select_time:select_time},
			dataType: "json",
			success:function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var info = data.info;
					//有基本信息操作基本信息
					if(data.default_info){
						default_info = data.default_info;
						fill_default_info(default_info,0,0,0,1);
					}
					//填充课表
					fill_timetable_info(info);
					//填充一周时间
					var week_time = data.select_start_time+' ~ '+data.select_end_time;
					$('#week_time').text(week_time);

					//填充时间戳
					$('#prev_time_stamp').val(data.select_start_time_stamp);
					$('#next_time_stamp').val(data.select_end_time_stamp);
				}
			}		
		});
	}

	//点击切换周
	function change_week_time(){
		$('#prev_week').click(function(){
			var time_stamp = $('#prev_time_stamp').val();
			var post_time = (parseInt(time_stamp)-8*3600)*1000;
			var weekDate = new Date(post_time);
			var year = weekDate.getFullYear();
			var month = weekDate.getMonth()+1;
			var day = weekDate.getDate();
			if(year<2000){
				year = year+1900;
			}
			if(month<10){
				month='0'+month;
			}
			if(day<10){
				day='0'+day;
			}
			post_time = year+'-'+month+'-'+day;
			get_timetable_info(0,0,0,post_time);
		});
		$('#next_week').click(function(){
			var time_stamp = $('#next_time_stamp').val();
			var post_time = (parseInt(time_stamp)+8*3600)*1000;
			var weekDate = new Date(post_time);
			var year = weekDate.getFullYear();
			var month = weekDate.getMonth()+1;
			var day = weekDate.getDate();
			if(year<2000){
				year = year+1900;
			}
			if(month<10){
				month='0'+month;
			}
			if(day<10){
				day='0'+day;
			}
			post_time = year+'-'+month+'-'+day;
			get_timetable_info(0,0,0,post_time);
		});
	}

	//填充课表
	function fill_timetable_info(data){
		var html = '';
		var teacher_id = $('#teacher_lists').val();
		if(data.length<10){
			$('.detail_table').html(html);
		}
		
		var week = ['周一','周二','周三','周四','周五','周六','周日'];
		$(data).each(function(i,value){
			var course_content_html = '';
			html+='<div class="weekend-course">\
					<div class="course-date">\
						<div class="aaa">'+week[parseInt(value.week-1)]+' '+value.day_time+'</div>\
					</div>\
					 <ul class="time-slide">';
			//课程时间
			$(value.content).each(function(m,cont){
				html+='<li>'+cont[0].course_time+'</li>';
				course_content_html+='<ul class="course-infor">';
				$(cont).each(function(n,con){
					var detail = con.detail;
					var users_content = '学员：'+detail.student_name_str;
					if(teacher_id<=0){
						users_content = '老师：'+detail.teacher_name;
					}
					var attr = 'room_no='+value.room_no+' students='+detail.student_name_str+' course_time='+cont[0].course_time;
					attr+=' open_time='+detail.open_time+' course_name='+detail.course_name+' teacher_id='+detail.teacher_id;
					course_content_html+='<li class="student-info" '+attr+'>\
									<span>课程：'+detail.course_name+'</span>\
									<span>机构：'+detail.ag_name+'</span>\
									<span>'+users_content+'</span>\
								</li>';
				});
				course_content_html+='</ul>';
			});
			html+='</ul><div class="course_lists">'+course_content_html+'</div></div>';
		});
		$('.detail_table').html(html);
		//监听点击时间
		course_detail();
	}

	//课程点击时间
	function course_detail(){
		$('.student-info').click(function(){
			var room_no = $(this).attr('room_no');
			var students = $(this).attr('students');
			var course_time = $(this).attr('course_time');
			var open_time = $(this).attr('open_time');
			var course_name = $(this).attr('course_name');
			var teacher_id = $(this).attr('teacher_id');

			var html = '<li>上课时间：<span>'+course_time+'</span></li>\
					<li>课程名称:<span>'+course_name+'</span></li>\
					<li>班级名称：<span>'+room_no+'</span></li>\
					<li>开班时间：<span>'+open_time+'</span></li>\
					<li>在读学员：<span>'+students+'</span></li>';
			$('.course-list').html(html);

			$('.getOut').show();
			$('.course').show();
			$('.aboluo-w-700').hide();
		});
	}

	$('.getOut').click(function(){
		$('.getOut').hide();
		$('.aboluo-w-700').hide();
	});

	//日历选择
	$('.calendar').click(function(){
		$('.getOut').show();
		$('.aboluo-w-700').show();
	});
	//日历确认
	$('.aboluo-ok').click(function(){
		$('.getOut').hide();
		var select_time = calendar_time;
		get_timetable_info(0,0,0,select_time);
	})

	//插入基本信息
	function fill_default_info(data,ag_id,teacher_id,student_id,first){
		var agency_html = '';
		var teacher_html = '<option value="0">全部</option>';
		var student_html = '<option value="0">全部</option>';
		$(data).each(function(i,v){
			var is_agency_select = '';
			var teacher_lists = v.teacher_lists;
	
			if(v.ag_id==ag_id || i==0){
				is_agency_select = 'selected';
				//没有选择老师显示全部学生
				if(teacher_id==0){
					//获取老师信息
					$(teacher_lists).each(function(m,t){
						var is_teacher_select = '';
						if(t.id==teacher_id){
							if(t.id==teacher_id){
								is_teacher_select = 'selected';
							}
						}
						var student_lists = t.student_lists;
						$(student_lists).each(function(n,s){
							var is_student_select = '';
							if(s.id==student_id){
								is_student_select = 'selected';
							}
							student_html+='<option value="'+s.id+'" '+is_student_select+'>'+s.name+'</option>';
						});
						teacher_html+='<option value="'+t.id+'" '+is_teacher_select+'>'+t.name+'</option>';
					});
				}else{
					//获取老师信息
					$(teacher_lists).each(function(m,t){
						var is_teacher_select = '';
						if(t.id==teacher_id){
							if(t.id==teacher_id){
								is_teacher_select = 'selected';
							}
							var student_lists = t.student_lists;
							$(student_lists).each(function(n,s){
								var is_student_select = '';
								if(s.id==student_id){
									is_student_select = 'selected';
								}
								student_html+='<option value="'+s.id+'" '+is_student_select+'>'+s.name+'</option>';
							});
						}
						teacher_html+='<option value="'+t.id+'" '+is_teacher_select+'>'+t.name+'</option>';
					});
				}
			}
			agency_html+='<option value="'+v.ag_id+'" '+is_agency_select+'>'+v.ag_name+'</option>';
		});
		$('#agency_lists').html(agency_html);
		$('#teacher_lists').html(teacher_html);
		$('#student_lists').html(student_html);

		//监听变化
		if(first==1){
			change_default_info();
		}
	}

	//监听变化机构老师学生信息
	function change_default_info(){
		$('#agency_lists,#teacher_lists,#student_lists').change(function(){
			var student_id = $('#student_lists').val();
			var ag_id= $('#agency_lists').val();
			var teacher_id= $('#teacher_lists').val();
			if(ag_id){
				get_timetable_info(ag_id,teacher_id,student_id);
				fill_default_info(default_info,ag_id,teacher_id,student_id,0);
			}
		});
	}

});

