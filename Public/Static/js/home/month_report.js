$(function(){
	var type= $('#web_type').val();
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('上课记录');

		if(type==1){
			$('#non-record').addClass('add_class');
			$('#month-hour').removeClass('add_class');
			$('.has_course').hide();
			$('.wait_infor').show();
		}else{
			$('#non-record').removeClass('add_class');
			$('#month-hour').addClass('add_class');
			$('.has_course').show();
			$('.wait_infor').hide();
		}
		//获取信息
		get_timetable_info(type);
	};

	function get_timetable_info(type,select_time){
		var click_node = $('#month-hour');
		if(type==1){
			click_node = $('#non-record');
		}
		var is_load = click_node.attr('is_load');
		if(is_load==1){
			return;
		}
		$.ajax({
			url:apiUrl+'Users/month_report',
			type: "POST",
			data:{openid:openid,type:type,select_time:select_time},
			dataType: "json",
			success:function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					if(type==0){
						$('#issign_today').text(data.today);
						$('#total_period').text(data.cnt);
						fill_issign_lists(data);
					}else{
						$('#nosign_today').text(data.today);
						fill_nosign_lists(data);
					}
					if(data.agency_lists){
						var agency_html = '';
						$(data.agency_lists).each(function(i,v){
							agency_html+='<option value="'+v.id+'">'+v.name+'</option>';
						});
						if(type==0){
							$('#issign_agency_lists').html(agency_html);
							$('#issign_today').text(data.today);
							$('#total_period').text(data.cnt);
						}else{
							$('#nosign_agency_lists').html(agency_html);
							$('#nosign_today').text(data.today);
						}
					}
				}
			}
		});
	}

	//未签到记录
	function fill_nosign_lists(data){
		var user_type = data.user_type;
		var nosign_html = '';
		$(data.timetable).each(function(i,v){
			var img_name = 'Yb_pulldown';
			var is_none = '';
			var is_up = 1;
			if(i>0){
				img_name = 'Yb_forward';
				is_none = 'none';
				is_up = 0;
			}
			nosign_html+='<div class="tail_infor">\
						<p class="timebar">\
							<span id="clock"><img src="/Static/images/home/Yb_time.png" alt=""></span>\
							<span>'+v.date+'</span>\
							<span class="calendar2"><img src="/Static/images/home/Yb_forward.png" class="up_img" alt="" is_up="'+is_up+'"></span>\
						</p>\
					<div  class="course_content '+is_none+'">';
			$(v.lists).each(function(m,n){
				var user_name = user_type==1 ? n.student_name : n.teacher_name;
				var user_id = user_type==1 ? n.student_id : n.teacher_id;
				nosign_html+='<div class="tail_course">\
							<ul class="tail_course_list">\
								<li>'+user_name+' '+n.ag_name+'</li>\
								<li>课程名称：'+n.course_name+'</li>\
								<li>上课时间：'+n.class_start_time+' ~ '+n.class_end_time+'</li>\
							</ul>\
							<div class="make_up" timetable_id="'+n.id+'" user_id="'+user_id+'">\
								<span>补卡</span>\
							</div>\
						</div>';
			});
			nosign_html+='</div></div></div>';
		});
		$('#nosign_lists').html(nosign_html);
		$('#non-record').attr('is_load',1);
		//监听打开切换
		click_timebar();
	}

	//点击隐藏信息
	function click_timebar(){
		$('.timebar').click(function(){
			var obj = $(this).find('.up_img');
			var is_up = obj.attr('is_up');
			var up_img = '/Static/images/home/Yb_pulldown.png';
			var down_img = '/Static/images/home/Yb_forward.png';
			if(is_up==0){
				$(this).parent().find('.course_content').removeClass('none');
				$(this).find('.up_img').attr('src',up_img);
				obj.attr('is_up',1);
			}else{
				$(this).parent().find('.course_content').addClass('none');
				$(this).find('.up_img').attr('src',down_img);
				obj.attr('is_up',0);
			}	
		});
	}

	//已经上课记录
	function fill_issign_lists(data){
		var issign_html = '';
		var user_type = data.user_type;
		$(data.timetable).each(function(i,v){
			issign_html+='<div class="date-information">\
						<div class="course-date">\
							<img src="/Static/images/home/Pk_time.png" alt="">\
							<span>'+v.date+'</span>\
						</div>';
			$(v.lists).each(function(m,n){
				var user_name = user_type==1 ? n.student_name : n.teacher_name;
				issign_html+='<ul class="course-information">\
							<li>'+user_name+'   '+n.ag_name+'</li>\
							<li>授课时间：\
								<span>'+n.class_start_day+'</span>\
								<span>'+n.class_start_time+' ~ '+n.class_end_time+'</span>\
							</li>\
							<li class="course-content">\
								<span>授课内容:</span>\
								<span>'+(n.remark ? n.remark : '无')+'</span>\
							</li>\
							<li>课  时：\
								<span>'+n.period+' 课时</span>\
							</li>\
						</ul> ';
			});
			issign_html+='</div>';
		});
		$('#issign_lists').html(issign_html);
		$('#month-hour').attr('is_load',1);
	}

	$('#month-hour').click(function(){
		$('.has_course').show();
		$('.wait_infor').hide();
		$(this).addClass('add_class').siblings().removeClass('add_class');
		get_timetable_info(0);
	})
	$('#non-record').click(function(){
		$('.has_course').hide();
		$('.wait_infor').show();
		$(this).addClass('add_class').siblings().removeClass('add_class');
		get_timetable_info(1);
	})
})