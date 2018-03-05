$(function(){
	var select_ag_id = sessionStorage.ag_id ? sessionStorage.ag_id : 0;
	var select_approver_id = sessionStorage.approver_id ? sessionStorage.approver_id : 0;
	var select_leave_type=sessionStorage.leave_type ? sessionStorage.leave_type :1;
	var clickObj = '';
	var date=new Date();
	var today = date.getFullYear()+'-'+parseInt(date.getMonth()+1)+'-'+date.getDate();
	var today_timestampe = parseInt(Date.parse(new Date(today)));

	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('请假');
		$('#leave_start_time').click(function(){
			$('.getOut').show();
			$('.aboluo-w-700').show();
			$('.ag-information').hide();
			$('.approver-information').hide();
			clickObj = $(this);
			time_select();
		});
		$('#leave_end_time').click(function(){
			$('.getOut').show();
			$('.aboluo-w-700').show();
			$('.ag-information').hide();
			$('.approver-information').hide();
			clickObj = $(this);
			time_select();
		});	
		ask_leave();
		ask_leave_infor();
	};

	function leave_total_day(){
		var leave_start_time = $('#leave_start_time').attr('time_stampe');
		var leave_end_time = $('#leave_end_time').attr('time_stampe');
		var leave_day_nums = parseInt((leave_end_time-leave_start_time)/24/3600)+1;
		leave_day_nums = leave_day_nums ? leave_day_nums : 0;
		$('#ask_leave-day').val(leave_day_nums);
	}

	//获取请假基本信息
	function ask_leave(){
		$.ajax({
			url:apiUrl+'Users/get_approve_info',
			type: "POST",
			data:{openid:openid},
			dataType: "json",
			success:function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					console.log(data);
					var leave_type=data.leave_type;
					if(data.user_type==1){
						$('#user_type').html("学生姓名：")
					}else if(data.user_type==2){
						$('#user_type').html("前台姓名：")
					}else if(data.user_type==3){
						$('#user_type').html("老师姓名：")
					}else{
						$('#user_type').html("老板姓名：")
					};
					$('#user_name').html(data.user_name);
					$('#user_name').attr('user_id',data.user_id);
					var html='';
					$('.addStyle').html()
					$(leave_type).each(function(i,v){
						html+='<option value="'+i+'" slected>'+v+'</option>'
						sessionStorage.leave_type=i;
					});
					$('#leave_type').append(html);
					$(data.info).each(function(i,v){
						var ag_html='';	
						//机构列表
						$('.approver-title').html('机构列表');
						ag_html+='<li><span ag_info="'+v.id+'">'+v.name+'</span><img src="/Static/images/home/Id_default.png"></li>'; 
						 $('.ag-list').append(ag_html); 	
						 angency();	 
						 //审批人列表
						var approve_list=v.approve;
						var approver_html='';
						$('.approver-title').html('审批人列表');
						$(approve_list).each(function(p,q){
							approver_html+='<li><span approver_id="'+q.user_id+'">'+q.name+'</span><img src="/Static/images/home/Id_default.png"></li>'	 
						});
						$('.approver-list').append(approver_html);	
						 approver();	 
						});	 
						}else{
							showMessage(data.msg);
						}
					}
			})
	}
	//选择机构或审批人列表
	 function angency(){
		$('.ag-list').find('li').click(function(){
			var is_selected = $(this).find('img').attr('is_selected');
			$('.ag-list').find('img').attr('src','/Static/images/home/Id_default.png');
			$('.ag-list').find('img').attr('is_selected',0);
			if(is_selected==1){
				$(this).find('img').attr('is_selected',0);
				$(this).find('img').attr('src','/Static/images/home/Id_default.png');
			}else{
				$(this).find('img').attr('is_selected',1);
				$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
			}
			var ag_id=$(this).find('span').attr('ag_info');
			var ag_name=$(this).find('span').html();
			sessionStorage.select_ag_id = ag_id;
			sessionStorage.select_ag_name = ag_name;
			if(is_selected==1){
				$('#ag_list').remove('ag_id');
				$('#ag_list').html('请选择机构')
			}else{
				$('#ag_list').attr('ag_id',sessionStorage.select_ag_id);
				$('#ag_list').html(sessionStorage.select_ag_name);
			}
			$('.ag-do').click(function(){
				$('.getOut').hide();				 
			})	 
		})
	 }
	 function approver(){
		$('.approver-list').find('li').click(function(){
			var is_selected = $(this).find('img').attr('is_selected');
			$('.approver-list').find('img').attr('src','/Static/images/home/Id_default.png');
			$('.approver-list').find('img').attr('is_selected',0);
			if(is_selected==1){
				$(this).find('img').attr('is_selected',0);
				$(this).find('img').attr('src','/Static/images/home/Id_default.png');
			}else{
				$(this).find('img').attr('is_selected',1);
				$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
			}
			var approver_id=$(this).find('span').attr('approver_id');
			var approver_name=$(this).find('span').html();
			sessionStorage.approver_id = approver_id;
			sessionStorage.approver_name = approver_name;
			if(is_selected==1){
				$('#approver').remove('approver_id');
				$('#approver').html('请选择审批人');
			}else{
				$('#approver').attr('approver_id',sessionStorage.approver_id);
				$('#approver').html(sessionStorage.approver_name);
			}
			$('.approver-do').click(function(){
			$('.getOut').hide();				 
		})	 
		})
	 }

	 //提交请假信息
	 function ask_leave_infor(){
	  $('#submit').click(function(){
	  	var ag_id=$('#ag_list').attr('ag_id');
	  	var approver_id=$('#approver').attr('approver_id');
		var leave_day=$('#ask_leave-day').val();
		var leave_content=$('#textarea').val();
		var start_time=$('#leave_start_time').val();
		var end_time=$('#leave_end_time').val();
		if(!leave_day){
			showMessage("请输入请假天数！")
		}else if(!leave_content){
			showMessage("请输入请假内容！")
		}else if(!start_time){
			showMessage('请输入开始请假时间！')
		}else if(!end_time){
			showMessage('请输入请假结束时间！')
		}else if(!ag_id){
			showMessage('请选择机构');
		}else if(!approver_id){
			showMessage('请选择审批人');
		}else{
			$.ajax({
				url:apiUrl+'Users/leave_apply',
				type: "POST",
				data:{
					openid:openid,
					ag_id:ag_id,
					leave_type:select_leave_type,
					leave_day:leave_day,
					start_time:start_time,
					end_time:end_time,
					content:leave_content,
					approve_id:approver_id
				},
				dataType: "json",
				success:function(data){
					if(data.status==-1){
						sessionStorage.avatar = data.avatar;
						window.location.href = baseUrl+'/Index/identification';
					}else if(data.status==1){
						showMessage(data.msg);
						// window.location.href = baseUrl+'/Index/index';
					}else{
						showMessage(data.msg);
					}
				}
			});
	 	 }
	 })
		 
	 }
	 $('#ag_list').click(function(){
		$('.getOut').show();
		$('.ag-information').show();
		$('.approver-information').hide();
		$('.aboluo-w-700').hide();
	 })
	 $('#approver').click(function(){
		$('.getOut').show();
		$('.ag-information').hide();
		$('.approver-information').show();
		$('.aboluo-w-700').hide();
	 })
	$('.ag-cancel').click(function(){
		$('.getOut').hide();
	});
	$('.approver-cancel').click(function(){
		$('.getOut').hide();
	});
	function time_select(){
		$('.aboluo-ok').click(function(){
			var select_time = calendar_time_timestampe*1000;
			var timestamp = Date.parse(new Date());
			if(select_time>=timestamp){
				var start_select=new Date(select_time);
				var select_year=start_select.getFullYear(); 
				var select_month=start_select.getMonth()+1;
				var select_day=start_select.getDate();
				if(select_month<10){
					select_month='0'+select_month;
				}
				if(select_day<10){
					select_day='0'+select_day;
				}
				start_time_html=select_year+'-'+select_month+'-'+select_day;
				clickObj.val(start_time_html);
				clickObj.attr('time_stampe',calendar_time_timestampe);
				start_time_html='';
				$('.getOut').hide();
				//计算天数
				leave_total_day();
			}else {
				showMessage('请假时间必须大于等于今天！');
			} 
		});
	}
})