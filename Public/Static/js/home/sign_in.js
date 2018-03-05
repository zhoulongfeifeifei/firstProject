$(function(){
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('签到');
		//获取基本信息
		get_default_info();
	};

	//跳转统计
	$('#goToData').click(function(){
		window.location.href = baseUrl+'/Users/month_report?type=1';
	});

	//提醒点名
	$('#course_notice').click(function(){
		var is_notice = $(this).attr('is_notice');
		var notice_msg = $(this).attr('notice_msg');
		if(is_notice!=1){
			showMessage(notice_msg);
		}else{
			course_notice();
		}
	});

	//课程提醒
	function course_notice(){
		var timetable_id = $('#sign_div').attr('timetable_id');

		$.ajax({
			type: "POST",
			url: apiUrl+'Course/course_notice',
			data: {openid:openid,timetable_id:timetable_id},
			dataType: "json",
			success: function(data){
				//未认证
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					showMessage(data.msg);
				}else{
					showMessage(data.msg);
				}
			}
		});
	}

	/**基础数据*/
	function get_default_info(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Users/sign_course_info',
			data: {openid:openid},
			dataType: "json",
			success: function(data){
				//未认证
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var user_type = data.user_type;
					var info = data.info;
					var sex_name = data.sex==1 ? '先生' : '女士'; 
					var sign_title = data.user_name+sex_name+'：欢迎您';
					

					$('#sign_div').attr('now_time',data.now_time);
					$('#sign_title').text(sign_title);
					//机构
					$('#sign_agency').text(data.ag_name);

					//不是老师
					if(user_type!=3){
						$('#sign_studens').hide();
						$('#course_content').hide();
					}

					//现在时间
					$('#now_time_hour').text(data.now_time_hour);
					$('#now_time_mins').text(data.now_time_mins);
					$('#now_time_s').text(data.now_time_s);

					set_now_time();
					$('#today_time').text(data.today);
					$('#course_notice').attr('notice_msg','暂无课程！');
					if(info){
						$('#course_notice').attr('notice_msg','');
						$('#sign_studens').text(info.student_name);
						$('#sign_course').text(info.course_name);

						//课程时间
						var course_time = '（'+info.class_start_time+'~'+info.class_end_time+'）';
						$('#course_time').text(course_time);

						//添加签到信息
						var sign_text = '上课签到';
						var is_sign = 0;
						var dis_time = parseInt(info.dis_time);
						if(dis_time>1800){
							sign_text = '未到时间';
							is_sign =1;
							$('#course_notice').attr('notice_msg','未到时间');
						}

						if(info.sign_time>0 || info.teacher_sign_time>0){
							sign_text = '已签到';
							is_sign =1;
						}

						
						//点名可用
						$('#course_notice').attr('is_notice',1);
						
						var html = '<span>'+sign_text+'</span>';
						$('#sign_div').html(html);
						$('#sign_div').attr('timetable_id',info.id);
						$('#sign_div').attr('is_sign',is_sign);
						$('#sign_div').attr('timetable_start_time',info.start_time);

					}
				}else{
					showMessage(data.msg);
				}
			}
		});
	}


	//时间实时
	function set_now_time(){
		var hour = parseInt($('#now_time_hour').text());
		var min = parseInt($('#now_time_mins').text());
		var s = parseInt($('#now_time_s').text());
		s++;
		if(s==60){
			min++;
			if(min==60){
				hour++;
				if(hour==24){
					hour=0;
				}
			}
			s=0;
		}
		if(min<10){
			min = '0'+min;
		}
		if(hour<10){
			hour='0'+hour;
		}

		$('#now_time_hour').text(hour);	
		$('#now_time_mins').text(min);	
		$('#now_time_s').text(s);	

		var now_time = parseInt($('#sign_div').attr('now_time'));
		var timetable_start_time = parseInt($('#sign_div').attr('timetable_start_time'));
		now_time++;
		$('#sign_div').attr('now_time',now_time);
		var dis_time = timetable_start_time-now_time;
		var is_sign = $('#sign_div').attr('is_sign');

		if(dis_time<=1800 && is_sign!=1){
			var html = '<span>上课签到</span>';
			$('#sign_div').attr('is_sign',0);
			//点名可用
			$('#course_notice').attr('is_notice',1);
		}
		$('#sign_div').html(html);
		setTimeout(function() { 
			set_now_time();
		}, 1000);
	}

	//签到
	$('#sign_div').click(function(){
		var is_sign = $(this).attr('is_sign');
		if(is_sign==1){
			return;
		}
		var timetable_id = $(this).attr('timetable_id');

		$.ajax({
			type: "POST",
			url: apiUrl+'Users/sign_course',
			data: {openid:openid,timetable_id:timetable_id},
			dataType: "json",
			success: function(data){
				//未认证
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var html = '<span>已签到</span><span id="now_clock"></span>';
					$('#sign_div').html(html);
					$('#sign_div').attr('is_sign',1);
					showMessage(data.msg);
				}else{
					showMessage(data.msg);
				}
			}
		});
	});

})