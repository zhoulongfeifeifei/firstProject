$(function(){
	var teacher_id = sessionStorage.arrange_teacher_id;
	var teacher_name = sessionStorage.arrange_teacher_name;
	var agency_id = sessionStorage.course_ag_id;
	var agency_name = sessionStorage.course_ag_name;
	var before_course_id=sessionStorage.arrange_student_course_id;
	var before_course_name=sessionStorage.arrange_student_course_name;
	var startWeek=sessionStorage.arrange_week;
	var startTime=sessionStorage.arrange_time;
	var week_no = parseInt(sessionStorage.arrange_week_no);
	var room_no =  sessionStorage.arrange_week;
	var studentInfo=sessionStorage.arrange_stu_html;
	var weekArr = ['周一','周二','周三','周四','周五','周六','周日']; 
	var date=new Date();
	var today = date.getFullYear()+'-'+parseInt(date.getMonth()+1)+'-'+date.getDate();
	var today_timestampe = parseInt(Date.parse(new Date(today)));
	var toDay=date.getDay();
	var aaa=2016+'-'+12+'-'+19+' '+startTime;
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('转课');
		$('#ag_id').html('机构：'+agency_name);
		$('#ag_id').attr('ag_id',agency_name);
		$('#before_teacher').html('原老师：'+teacher_name);
		$('#before_teacher').attr('teacher_id',teacher_id);
		$('#course_room').val(room_no);
		$('#before_time').val(weekArr[week_no]);
		$('#select_course_name').attr('courseId',before_course_id);
		$('#select_course_name').val(before_course_name);
		$('#select_student').append(studentInfo);
		var date_time=0;
			if(toDay>(week_no+1) || toDay==week_no){
				 date_time=7-(toDay-(week_no+1));
				// alert(12);
			}else{
				var date_time=7-week_no-1;
			}
		selecttTime=today_timestampe+24*3600*date_time;
		var prevSelect=new Date(selecttTime); 
		var year=prevSelect.getFullYear()
		var month=prevSelect.getMonth()+1;
		var day=prevSelect.getDate();
		if(month<10){
			month='0'+month
		}
		if(day<10){
			day='0'+day
		}
		var html='';
		html=year+'-'+month+'-'+day;
		var first_time =html+' '+startTime;
		$('#week_name').text(weekArr[week_no]);
		$('#first_time').text(startTime);
			teacher_list();
			var new_teacher_list=sessionStorage.select_new_teacher_list;
			$('#select_teacher').append(new_teacher_list);
			var teach_html='';
			$('#select_teacher span').each(function(i,v){
				var new_teacher_id=$(this).attr('new_teacher_id');
				var new_teacher_name=$(this).text();
				teach_html+='<li id="'+new_teacher_id+'">\
				<span>'+new_teacher_name+'</span><img src="/Static/images/home/Id_default.png"></li>';
			})
			$('.teacher-list').append(teach_html);

			//选择老师
			$('.teacher-list').find('li').click(function(){
				var is_selected=$(this).attr('is_selected');
				if(is_selected==1){
					$(this).attr('is_selected',0);
					$(this).removeClass('approve-li-style');
					$(this).find('img').attr('src','/Static/images/home/Id_default.png');
					$('#teacher_id').val('请输入新老师姓名')
					$('#teacher_id').remove('teacher_id');
				}else{
					$(this).attr('is_selected',1);
					$(this).addClass('approve-li-style');
		     	 	$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
		     	 	$('#teacher_id').attr('teacher_id',$(this).attr('id'))
		     	 	$('#teacher_id').val($(this).find('span').text());
		     	 	teacher_time();
				}
			})
			//弹出层确认
			$('.teacher-do').click(function(){
			   $('.getOut').hide();
			 });
		 turn_course();
	};
	var stu_infor='';
	var stu_list='';
	$('#select_student span').each(function(i,v){
		var week=$(this).attr('week');
		var stu_id=$(this).find('option').val();
		var stu_name=$(this).find('option').text();
		stu_infor+='<li id="'+stu_id+'" week="'+week+'">\
		<span>'+stu_name+'</span><img src="/Static/images/home/Id_default.png"></li>'
	});
	$('.approver-list').append(stu_infor);
	$('#studentName').append(stu_list);
	$('.approver-list').find('li').click(function(){
		var is_selected=$(this).attr('is_selected');
		if(is_selected==1){
			$(this).attr('is_selected',0);
			$(this).removeClass('approve-li-style');
			$(this).find('img').attr('src','/Static/images/home/Id_default.png');
			$('#PrintName').val('请输入学员姓名')
			$('#PrintName').remove('stu_id');
		}else{
			$(this).attr('is_selected',1);
			$(this).addClass('approve-li-style');
     	 	$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
     	 	$('#PrintName').attr('stu_id',$(this).attr('id'))
     	 	$('#PrintName').val($(this).find('span').text());
		}
	})
	//弹出层确认
	$('.approver-do').click(function(){
	   $('.getOut').hide();
	 });
	//转课信息
	function turn_course(){
		$('#turn_course_do').click(function(){
			var new_teacher_id=$('#teacher_id').attr('teacher_id');
			var new_teacher=$('#teacher_id').val();
			var course_id=$('#select_course_name').attr('course_id');
			var course_name=$('#select_course_name').val();
			var PrintName=$('#PrintName').val();
			if(!new_teacher){
				showMessage('请选择新老师！')
			}else if(!course_name){
				showMessage('请选择课程！')
			}else if(!PrintName){
				showMessage('请输入学员姓名！')
			}
			else{
				$.ajax({
					type: "POST",
					url: apiUrl+'Course/change_course',
					data: {
						ag_id:agency_id,
						openid:openid,
						src_teacher_id:teacher_id,
						src_room_no:room_no,
					    new_teacher_id:new_teacher_id,
						course_id:before_course_id,
						new_first_time:aaa
					},
					dataType: "json",
					success:function(data){
						if(data.status==-1){
							sessionStorage.avatar = data.avatar;
							window.location.href = baseUrl+'/Index/identification';
						}else if(data.status==1){
							showMessage(data.msg);
						}else{
							showMessage(data.msg)
						}
					}
				});
			}
		})
 	 };
 	 $('#turn_course_cancel').click(function(){
 	 	window.history.go(-1);
 	 })
 	 $('#select_time').click(function(){
 	 	$('.getOut1').show();
 	 	$('.timetable').show();
 	 });
 	 $('.getOut1').click(function(){
 	 	$(this).hide();
 	 	$('.timetable').hide();
 	 })
	$('#student-list').click(function(){
		$('.getOut').show();
		$('.courselist').hide();
		$('.aboluo-w-700').hide();
		$('.teacher_information').hide();
		$('.approver-information').show();
	});
	$('#teacher_id').click(function(){
		$('.getOut').show();
		$('.teacher-information').show();
		$('.courselist').hide();
		$('.aboluo-w-700').hide();
		$('.approver-information').hide();
	})
	$('.approver-cancel').click(function(){
		$('.getOut').hide();
	});
	$('.teacher-cancel').click(function(){
		$('.getOut').hide();
	});
	$('.aboluo-ok').click(function(){
		$('.getOut').hide();
	});
	$('#clock').click(function(){
		$('.getOut').show();
		$('.aboluo-w-700').show();
		$('.courselist').hide();
		$('.approver-information').hide();
		$('.teacher_information').hide();
	});
	$('.aboluo-ok').click(function(){
		var select_time = calendar_time;
		var first_time = select_time+' '+startTime;
		$('#week_name').text(weekArr[week_no]);
		$('#first_time').text(first_time);
		$('.getOut').hide();
	}) 
	//老师列表
	function teacher_list(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Users/get_teacher_lists',
			data: {ag_id:agency_id,openid:openid},
			dataType: "json",
			success:function(data){
				if(data.status==0){
					showMessage(data.msg);
				}else{
					var lists=data.lists;
					var teacher_html='';
					$(data.lists).each(function(i,v){
						teacher_html+='<span new_teacher_id="'+v.id+'">'+v.name+'</span>'
					});
					sessionStorage.select_new_teacher_list=teacher_html;
				}
			}
		});
	}
	function teacher_time(teacher_id){
		var teacher_id=$('#teacher_id').attr('teacher_id');
		$.ajax({
			type:"POST",
			url:apiUrl+'Users/get_teacher_time',
			data:{
				openid:openid,
				ag_id:agency_id,
				teacher_id:teacher_id
			},
			dataType:"json",
			success:function(data){
				if(data.status==0){
					showMessage(data.msg);
				}else if(data.status==1){
					 var lists=data.lists;
					 var time_line=data.time_line;
					 var lists_html='';
					 var time_html='';
					 $(time_line).each(function(i,v){
					 	time_html+='<li>'+v+'</li>'
					 });
					 console.log(lists);
					 $('#time_line_lists').html('<li class="time_line_first"></li>'+time_html);
					 
				}
			}
		});
	}
	 
})