$(function(){

	var agency = new Array();
	var content = new Array();
	var time_line = new Array();
	var mySwiper = '';

	var select_teacher_id = sessionStorage.arrange_select_teacher_id ? sessionStorage.arrange_select_teacher_id : 0;
	var select_ag_id = sessionStorage.course_ag_id ? sessionStorage.course_ag_id : 0;
	var select_student_id=sessionStorage.arrange_select_student_id? sessionStorage.arrange_select_student_id : 0;
	var student_course_id=sessionStorage.arrange_student_course_id? sessionStorage.arrange_student_course_id : 0;
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('排课');
		get_default_info();
	};
	function swiper(){
		mySwiper = new Swiper('#mySwipe',{
			autoplay : 0,//可选选项，自动滑动
			loop : true,//可选选项，开启循环
			speed:500,
			autoplayDisableOnInteraction:false,
		})
	
	}

	function get_default_info(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Course/get_timetable_default',
			data: {openid:openid},
			dataType: "json",
			success: function(data){
					//未认证
				// console.log(data.week)
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var agency_lists = data.lists;
					var agency_html = '';
					
					var weekArr = ['周一','周二','周三','周四','周五','周六','周日'];
					$(agency_lists).each(function(i,v){
						var teacher_html = '';
						//初始化机构信息
						if( (i==0 && select_ag_id==0) || select_ag_id==v.id ){
							sessionStorage.course_ag_id = v.id;
							sessionStorage.course_ag_name = v.name;
							agency_html+='<option value="'+v.id+'" slected>'+v.name+'</option>';
						}else{
							agency_html+='<option value="'+v.id+'">'+v.name+'</option>';
						}

						
						var teacher_lists = v.teacher_lists;
						$(teacher_lists).each(function(m,n){
							//时间轴
							var time_line_html= '<li style="height:0.34rem;">&nbsp</li>';
							var times = n.time_line;
							$(times).each(function(x,y){
								time_line_html+='<li>'+y+'</li>';
							});
							if((m==0 && select_teacher_id==0) || select_teacher_id==n.id){
								//插入时间轴
								$('#time_line_lists').html(time_line_html);
								//插入老师信息
								$('#select_teahcer').attr('teacher_id',n.id);
								$('#select_teahcer').text(n.name);
								$('#box_teahcer').text(n.name);
							}

							//保存老师的时间轴
							time_line[n.id] = time_line_html;

 							//课程
							var course_lists = n.course_lists;
							var teacher_course_html = '';
							var course_html = '';
							$(course_lists).each(function(x,y){
								var li_selected = '';
								if(x==0 || x==2 || x==4 || x==6){
									course_html += '<li class="swiper-slide">';
									li_selected = 'li_selected';
								}
								key = x;
								if(x==6){
									key = 5;
								}else if(x==7){
									key = 6;
								}
								
								course_html+='<div class="time_day">\
											<ul class="table_line">\
												<li class="line_title">'+weekArr[key]+'</li>';

								$(y).each(function(k,c){

									var select_class = 'no_course';
									var p_font = 'default_font';
									if(c.is_selected==0){
										select_class = 'h_course';
									}
									if(c.ag_id){
										if(c.is_selected==1){
											p_font = 'select_font';
										}
										var stu_html='<span week="'+(key+1)+'-'+(k+1)+'">';
										$(c.detail).each(function(sts,st){
											stu_html+='<option value="'+st.student_id+'" >'+st.student_name+'</option>'
										});
										stu_html+='</span>';
										$('#li_students').append(stu_html);
										course_html+='<li room_no="'+c.room_no+'" week_no="'+key+'" week="'+(key+1)+'-'+(k+1)+'" li_time="'+times[k]+'"  end_time="'+times[k+1]+'" class="'+select_class+'   '+li_selected+'  '+p_font+'">\
													<p style="height:0.06rem;width:100%;">&nbsp</p>\
													<p>课程：'+'<span id="select_course" st_course="'+c.course_id+'">'+c.course_name+'</span></p>\
													<p>机构：'+v.name+'</p>\
													<p id="select_student" student_id="'+c.detail[0].student_id+'">学员:<span>'+c.detail[0].student_name+'</span></p>\
												</li>';

									}else{
										course_html+='<li week_no="'+key+'" week="'+(key+1)+'-'+(k+1)+'" li_time="'+times[k]+'" end_time="'+times[k+1]+'" class="'+select_class+'   '+li_selected+'  '+p_font+'"></li>';
									}
								});
								course_html += '</ul></div>';
								if(x==1 || x==3 || x==5 || x==7){
									course_html += '</li>';
								}
							});
							if((m==0 && select_teacher_id==0) || select_teacher_id==n.id){
								$('#course_lists').html(course_html);
							}
							content[n.id] = course_html;
							
						});
						agency[v.id] = teacher_html;
					});
					//插入机构
					$('#agency_lists').html(agency_html);
					swiper();

					//监听机构变化
					change_angecy();

					$('.table_line').find('li').click(function(){
						var obj = $(this);
						do_timetable(obj);
					});
				}else{
					showMessage(data.msg);
				}
			}
		});
	}


	function change_angecy(){
		$('#agency_lists').change(function(){
			var ag_id = $(this).val();
		});
	}


	//点击日历标识
	$('.calendar').click(function(){
		$('.dateChange').show();
		$('.getOut').show();
	});
	//隐藏日历标识
	$('.getOut,#cancel_calendar').click(function(){
		$('.dateChange').hide();
		$('.courseChange').hide();
		$('.getOut').hide();
	});

	//选择日历星期
	$('.dateChange').find('li').click(function(){
		$(this).parent().find('li').removeClass('dateChange-li');
		$(this).addClass('dateChange-li');
	});

	//确认日历选择
	$('#sure_calendar').click(function(){
		var silder_index = $('.dateChange-li').attr('silder_index');
		mySwiper.slideTo(silder_index,1000,false);
		$('.dateChange').hide();
		$('.getOut').hide();

	});

	//点击老师跳转
	$('#select_teahcer').click(function(){
		window.location.href = baseUrl+'/Users/teacher_lists';
	});

	//点击弹出
	function do_timetable(obj){
		$('.courseChange').show();
		$('.getOut').show();
		var week = obj.attr('week');
		var time = obj.attr('li_time');
		var end_time = obj.attr('end_time');
		var week_no = obj.attr('week_no');
		//选择的星期
		 sessionStorage.arrange_week = String(week);

		 sessionStorage.arrange_week_no = parseInt(week_no);
		
		//选择的时间
		 sessionStorage.arrange_time = String(time);

		  sessionStorage.arrange_end_time  = end_time;

		//授课老师
		sessionStorage.arrange_teacher_id = $('#select_teahcer').attr('teacher_id');
		//老师姓名
		sessionStorage.arrange_teacher_name = $('#select_teahcer').text();

		var student_html = $('#li_students').find('span[week='+week+']').html();
		//课程名称
		sessionStorage.arrange_student_course_id =$('#select_course').attr('st_course');
		sessionStorage.arrange_student_course_name=$('#select_course').text();
		sessionStorage.arrange_stu_html=$('#li_students').html();
	}
	

	//新增课时
	$('.addCourse').click(function(){
		window.location.href=baseUrl+'/Course/add_classhour';
	});
	//转课
	$('.selectCourse').click(function(){
		window.location.href=baseUrl+'/Course/turn_course';
	});
	//续课
	$('.xuCourse').click(function(){
		window.location.href=baseUrl+'/Course/continue_course';
	});

	//有课操作
	
	$('.hasCourse').click(function(){
		var ag_id = select_ag_id ? select_ag_id : sessionStorage.course_ag_id;
		var teacher_id = select_teacher_id ? select_teacher_id : sessionStorage.arrange_teacher_id;
		var student_id= select_student_id? select_student_id:sessionStorage.arrange_student_id;
		var student_name= sessionStorage.arrange_student_name;
		var room_no =  sessionStorage.arrange_week;
		var start_time = sessionStorage.arrange_time;
		var end_time = sessionStorage.arrange_end_time;
		var week = sessionStorage.arrange_week_no;

		$.ajax({
			type: "POST",
			url: apiUrl+'Course/has_course',
			data: {
				openid:openid,
				ag_id:ag_id,
				teacher_id:teacher_id,
				start_time:start_time,
				end_time:end_time,
				room_no:room_no,
				week:parseInt(week)+1,
			},
			dataType: "json",
			success: function(data){
				//未认证
				// console.log(data.week)
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					$('.dateChange').hide();
					$('.courseChange').hide();
					$('.getOut').hide();
					$('.table_line').find('li[week='+room_no+']').addClass('pointer_none');
					setTimeout(function(){
						showMessage(data.msg);
					},200);
				}else{
					showMessage(data.msg);
				}
			}
		});
	});

})