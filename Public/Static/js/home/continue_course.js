$(function(){
	var teacher_id = sessionStorage.arrange_teacher_id;
	var teacher_name = sessionStorage.arrange_teacher_name;
	var agency_id = sessionStorage.course_ag_id;
	var agency_name = sessionStorage.course_ag_name;
	var startWeek=sessionStorage.arrange_week;
	var startTime=sessionStorage.arrange_time;
	var week_no = parseInt(sessionStorage.arrange_week_no);
	var date=new Date();
	var today = date.getFullYear()+'-'+parseInt(date.getMonth()+1)+'-'+date.getDate();
	var today_timestampe = parseInt(Date.parse(new Date(today)));
	var weekArr = ['周一','周二','周三','周四','周五','周六','周日'];
	var toDay=date.getDay();
	var studentInfo=sessionStorage.arrange_stu_html;
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('续课');
		$('#agency_name').text(agency_name);
		$('#select_student').append(studentInfo);
		//关闭页面
		$('#closeBtn').click(function(){
			window.history.go(-1); 
		});
		var date_time=0;
		if(toDay>(week_no+1) || toDay==week_no){
		 date_time=7-(toDay-(week_no+1));
		}else{
			 date_time=7-week_no-1;
		};
		var selectTime=today_timestampe+24*3600*1000*date_time;
		var prevSelect=new Date(selectTime); 
		var year=prevSelect.getFullYear()
		var month=prevSelect.getMonth()+1;
		var day1=prevSelect.getDate();
		if(month<10){
			month='0'+month;
		}
		if(day1<10){
			day1='0'+day1;
		}
		var html='';
		html=year+'-'+month+'-'+day1;
		var first_time =html+' '+startTime;
		$('#first_time').text(first_time);
		$('#teacher_name').text('授课老师：'+' '+teacher_name);
		continue_course();
	};
	$('#student_name').click(function(){
		$('.getOut').show();
		$('.approver-information').show();
		$('.aboluo-w-700').hide();
	});
	$('.approver-cancel').click(function(){
		$('.getOut').hide();
	})
	$('#workdateImg').click(function(){
		$('.getOut').show();
		$('.aboluo-w-700').show();
	    $('.approver-information').hide();
	})
	$('.aboluo-ok').click(function(){
		$('.getOut').hide();
	});
	 
	//日期选择
	$('.aboluo-ok').click(function(){
		var select_time = calendar_time;
		var first_time = select_time+' '+startTime;
		$('#first_time').text(first_time);
	});
	var stu_infor='';
	$('#select_student span').each(function(i,v){
		var week=$(this).attr('week');
		var stu_id=$(this).find('option').val();
		var stu_name=$(this).find('option').text();
		stu_infor+='<li id="'+stu_id+'" week="'+week+'">\
		<span>'+stu_name+'</span><img src="/Static/images/home/Id_default.png"></li>'
		 
	});
	$('.approver-list').append(stu_infor);
	$('.approver-list li').eq(0).find('img').attr('src','/Static/images/home/Id_selected.png');
	$('.approver-list').find('li').click(function(){
		var is_selected=$(this).attr('is_selected');
		if(is_selected==1){
			$(this).attr('is_selected',0);
			$(this).removeClass('approve-li-style');
			$(this).find('img').attr('src','/Static/images/home/Id_default.png')
		}else{
			$(this).attr('is_selected',1);
			$(this).addClass('approve-li-style');
     	 	$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
		}
	})

		 //弹出层确认
	 $('.approver-do').click(function(){
	 	$('.approver-list').find('li').each(function(i,v){
	 		 $('#student_name').val($(this).text());
	 		 $('#student_name').attr('stu_id',v.id);
	 		 $('.getOut').hide();
	 });
	 })
 	//续课
	function continue_course(){
	$('#sureBtn').click(function(){
		var student_name = $('#student_name').val();
		var start_time = $('#startTime').text();
		var course_hour= $('#course_hour').val();
		var first_time = $('#first_time').text();
		var stu_id=$('#student_name').attr('stu_id');
		if(!course_hour){
			showMessage('请输入课时！');
		}
		else{
			$.ajax({
				type: "POST",
				url: apiUrl+'Course/continue_course',
				data: {
					ag_id:agency_id,
					openid:openid,
					teacher_id:teacher_id,
					student_id:stu_id,
					week:startWeek,
					period:course_hour,
					start_time:first_time},
				dataType: "json",
				success: function(data){
					alert(data.msg)
					return;
					if(data.status==-1){
						sessionStorage.avatar = data.avatar;
						window.location.href = baseUrl+'/Index/identification';
					}else if(data.status==1){
						showMessage(data.msg);
						 setTimeout(function(){
							window.history.go(-1); 
						 },800);
					}else if(date.status==0){
						showMessage(data.msg);
					}
				}
			});
		}

	});
	};
})