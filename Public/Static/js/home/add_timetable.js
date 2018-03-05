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
	//获取当前时间为周几
	var date=new Date();
	var toDay=date.getDay();
	// alert(toDay); 
	var grade=['小班','中班','大班','一年级','二年级','三年级','四年级','五年级','六年级','其他'];
	var weekArr = ['周一','周二','周三','周四','周五','周六','周日']; 
	// alert(toDay);
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('新增课时');
		$('#agency_name').text('机构：'+agency_name);
		$('#teacher_name').text('授课老师：'+teacher_name);

		//关闭页面
		$('#closeBtn').click(function(){
			window.history.go(-1); 
		});
		//性别切换
		$('.mansex').click(function(){
			var is_select = $(this).attr('is_select');
			if(is_select!=1){
				$(this).attr('is_select',1);
				$(this).attr('src','/Static/images/home/Pk_man_click.png');
				$('.womansex').attr('is_select',0);
				$('.womansex').attr('src','/Static/images/home/Pk_woman_default.png');
			}
		});
		//年级
		var grade_html='';
		$(grade).each(function(i,v){
			grade_html+='<option value="'+i+'" selected>'+grade[i]+'</option>';
		});
		$('#student_grade').html(grade_html);
		$('.womansex').click(function(){
			var is_select = $(this).attr('is_select');
			if(is_select!=1){
				$(this).attr('is_select',1);
				$(this).attr('src','/Static/images/home/Pk_woman_click.png');
				$('.mansex').attr('is_select',0);
				$('.mansex').attr('src','/Static/images/home/Pk_man_default.png');
			}
		});
		var date_time=0;
		if(toDay>(week_no+1) || toDay==week_no){
			 date_time=7-(toDay-(week_no+1));
			// alert(12);
		}else{
			var date_time=7-week_no-1;
		}
		// selecttTime=calendar_time_timestampe+24*3600*date_time;
		 selecttTime=today_timestampe+24*3600*date_time;
		// var prevSelect=new Date(selecttTime*1000);
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
		$('#first_time').text(first_time);
		add_student();
	};

	function add_student(){
		$('#sureBtn').click(function(){
			var student_name = $('#student_name').val();
			var course_hour = $('#course_hour').val();
			var mobile = $('#mobile').val();
			var tel_phone = $('#tel_phone').val();
			var grade_id=$('#student_grade').val();
			var mansex = $('.mansex').attr('is_select');
			var womansex = $('.womansex').attr('is_select');
			var select_course=$('#select_course_name').val();
			var course_id=$('.course_select_img').attr('course_id')
			var sex = mansex ==1 ? 1 : 2;
			var start_time = $('#startTime').text();

			var first_time = $('#first_time').text();
			var patt = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|170[0-9]{8}$|14[0-9]{1}[0-9]{8}$/;
			
			if(!student_name){
				showMessage('请输入姓名！');
			}else if(!course_hour){
				showMessage('请输入课时！');
			}else if(!mobile){
				showMessage('请输入手机号！');
			}else if(!select_course){
				showMessage('请选择课程')
			}
			else{
				if(!patt.test(mobile)){
					showMessage('手机号码格式错误！');
					return;
				}
				$.ajax({
					type: "POST",
					url: apiUrl+'Course/add_timetable',
					data: {ag_id:agency_id,openid:openid,name:student_name,sex:sex,mobile:mobile,tel_phone:tel_phone,first_time:first_time,teacher_id:teacher_id,period:course_hour,grade:grade_id,week:startWeek,course_id:course_id},
					dataType: "json",
					success: function(data){
						showMessage(data.msg);
						if(data.status==-1){
							sessionStorage.avatar = data.avatar;
							window.location.href = baseUrl+'/Index/identification';
						}else if(data.status==1){
							showMessage(data.smg);
							setTimeout(function(){
								window.history.go(-1); 
							},800);
						}else if(data.status==2){
							window.history.go(-1); 
						}else if(data.status==0){
							showMessage(data.smg);
						}
					}
				});
			}

		});
	};
	//选择年级
	//加载课程列表
	$('.teacherinfirmation-li2').click(function(){
		if($('.courselist-list').html().length<50){
			get_agency_course();
		}
		$('.courselist').show();
		$('.zezhao').show();
	});
	function get_agency_course(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Course/get_teacher_course',
			data: {ag_id:agency_id,openid:openid,teacher_id:teacher_id},
			dataType: "json",
			success: function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var course_lists = data.course_lists;
					var html = '';
					$(course_lists).each(function(i,v){
						var is_show = 'none';
						var uphtml = '<img src="/Static/images/home/Pk_pulldown.png" alt="" class="jiantou">';
						if(i==0){
							is_show = '';
							uphtml = '';
						}
						html+='<li class="courselist-li">\
							<div class="coursename-select" is_show="'+is_show+'"> \
								<span class="coursename">'+v.name+'</span>'+uphtml+'</div>\
							   <ul class="coursestyle '+is_show+'">';
						$(v.child).each(function(m,n){
							html+='<li>\
									<span>'+n.name+'</span>\
									<img class="course_select_img" is_selected="0" course_name="'+n.name+'" course_id="'+n.id+'" src="/Static/images/home/Id_default.png">\
								</li>';
						});
						html+='</ul></li>';
					});
					$('.courselist').show();
					$('.courselist-list').html(html);
					select_course();
				}else if(data.status==2){
					showMessage(data.msg);
					window.history.go(-1); 
				}else{
					showMessage(data.msg);
				}
			}
		});
	};
	$('.zezhao').click(function(){
		$('.courselist').hide();
		$('.zezhao').hide();
	});
	function select_course(){
		//监听是否打开
		$('.coursename-select').click(function(){
			var obj = $(this).parent();
			var html = '<img  src="/Static/images/home/Pk_pulldown.png" alt="" class="jiantou">';
			var listNode = obj.find('.coursestyle');
			var is_show = $(this).attr('is_show');
			if(is_show=='none'){
				$(this).attr('is_show','');
				listNode.removeClass('none');
				$(this).find('img').remove();
			}else{
				$(this).attr('is_show','none');
				listNode.addClass('none');
				$(this).append(html);
			}
		});

		$('.coursestyle').find('li').click(function(){
			var is_selected = $(this).find('img').attr('is_selected');
			$('.coursestyle').find('img').attr('src','/Static/images/home/Id_default.png');
			$('.coursestyle').find('img').attr('is_selected',0);
			$('#select_course_name').val('');
			if(is_selected==1){
				$(this).find('img').attr('is_selected',0);
				$(this).find('img').attr('src','/Static/images/home/Id_default.png');
			}else{
				$(this).find('img').attr('is_selected',1);
				$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
				$('#select_course_name').val($(this).find('img').attr('course_name'));
			}
		});
	}
	//选择日期
	$('#workdateImg,#workdate').click(function(){
		$('.aboluo-w-700').show();
		$('.getOut').show();

	});
	$('.aboluo-ok').click(function(){
		$('.aboluo-w-700').hide();
		$('.getOut').hide();
	});

	$('.aboluo-ok').click(function(){
		var select_time = calendar_time;
		var first_time = select_time+' '+startTime;
		$('#week_name').text(weekArr[week_no]);
		$('#first_time').text(first_time);
	});
	

})


