$(function(){
	var type=$('#web_type').val();
	type = sessionStorage.lleave_click_type ? sessionStorage.lleave_click_type : type;
	 var page0 = 1;
	 var page1 = 1;
	 var is_last0 = false;
	 var is_last1 = false;
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('待审批');

		//头部切换
		change_tab(type);
		//加载数据
		loadPageData(type);
	};
	function loadPageData(type,keywords){
		var page = page0;
		var is_last = is_last0;
		if(type==1){
			page=page1;
			is_last= is_last1;
		}
		if(is_last){
			return;
		}
		$.ajax({
			url:apiUrl+"Users/approve_lists",
			type:"POST",
			data:{openid:openid,type:type,page:page,keywords:keywords},
			dataType:"json",
			success:function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					if(type==0){
						//填充等待审批
						fill_wait_lists(data);
						$('.wait_approval').attr('is_load',1);
					}else{
						fill_other_lists(data);
						$('.access_approval').attr('is_load',1);
					}
					//事件监听
					get_detail_content();
				}else{
					showMessage(data.msg);
				}
			}
		});
	};

	//等待审批
	function fill_wait_lists(data){
		var lists = data.lists;
		if(lists.length<=0){
			is_last0 = true;
			if(page0==1){
				$('#wait_content').addClass('non-wait');
			}
		}else{
			$('#wait_content').removeClass('non-wait');
			//填充数据
			var html = '';
			$(lists).each(function(i,v){
				var status_name = '待审批';
				if(v.status==0){
					var attr = ' ag_name='+v.ag_name+' avatar='+v.avatar+' user_name='+v.user_name+' leave_type='+v.leave_type;
					attr+=' start_time='+v.start_time+' end_time='+v.end_time+' leave_day='+v.leave_day+' update_time='+v.update_time;
					attr+=' content='+v.content+' leave_id='+v.id+' approve_id='+v.approve_id+' approve_name='+v.approve_name;
					attr+=' approve_time='+v.approve_time+' approve_avatar='+v.approve_avatar+' status='+v.status+' apply_time='+v.apply_time;
					html+= '<div class="wait_on" '+attr+'>\
							<ul>\
								<li><img src="'+v.avatar+'" alt="" class="head_portrait"></li>\
								<li class="wait_on_infor">\
									<p>'+v.user_name+'</p>\
									<a href="javascript:;">'+status_name+'</a>\
								</li>\
								<li class="wait_on_time">'+v.create_time+'</li>\
							</ul>\
						</div>';
				}
			});
			$('.wait_on_list').append(html);
			page0++;
		}
	}

	

	//已审批
	function fill_other_lists(data){
		var lists = data.lists;
		if(lists.length<=0){
			is_last1 = true;
			if(page1==1){
				$('#other_content').addClass('non-wait');
			}
		}else{
			$('#other_content').removeClass('non-wait');
			//填充数据
			var html = '';
			$(lists).each(function(i,v){
				var status_name = '待审批';
				if(v.status==1){
					status_name = '审批完成(同意)';
				}else if(v.status==2){
					status_name = '审批完成(拒绝)';
				}
				var attr = ' ag_name='+v.ag_name+' avatar='+v.avatar+' user_name='+v.user_name+' leave_type='+v.leave_type;
				attr+=' start_time='+v.start_time+' end_time='+v.end_time+' leave_day='+v.leave_day+' update_time='+v.update_time;
				attr+=' content='+v.content+' leave_id='+v.id+' approve_id='+v.approve_id+' approve_name='+v.approve_name;
				attr+=' approve_time='+v.approve_time+' approve_avatar='+v.approve_avatar+' status='+v.status+' apply_time='+v.apply_time;
				html+= '<div class="wait_on" '+attr+'>\
						<ul>\
							<li><img src="'+v.avatar+'" alt="" class="head_portrait"></li>\
							<li class="wait_on_infor">\
								<p>'+v.user_name+'</p>\
								<a href="javascript:;">'+status_name+'</a>\
							</li>\
							<li class="wait_on_time">'+v.create_time+'</li>\
						</ul>\
					</div>';
			});
			$('.access_list').append(html);
			page1++;
		}
	}


	//信息
	function get_detail_content(obj){
		$('.wait_on_list,.access_list').find('.wait_on').click(function(){
			var ag_name = $(this).attr('ag_name');
			var avatar = $(this).attr('avatar');
			var user_name = $(this).attr('user_name');
			var leave_type = $(this).attr('leave_type');
			var start_time = $(this).attr('start_time');
			var end_time = $(this).attr('end_time');
			var leave_day = $(this).attr('leave_day');
			var content = $(this).attr('content');
			var leave_id = $(this).attr('leave_id');
			var approve_id = $(this).attr('approve_id');
			var approve_name = $(this).attr('approve_name');
			var approve_time = $(this).attr('approve_time');
			var approve_avatar = $(this).attr('approve_avatar');
			var status = $(this).attr('status');
			var apply_time = $(this).attr('apply_time');
			var update_time = $(this).attr('update_time');

			var type = $('.add_style').attr('type');
			sessionStorage.lleave_click_type = type;
			sessionStorage.leave_ag_name = ag_name;
			sessionStorage.leave_user_avatar = avatar;
			sessionStorage.leave_user_name = user_name;
			sessionStorage.leave_leave_type = leave_type;
			sessionStorage.leave_start_time = start_time;
			sessionStorage.leave_end_time = end_time;
			sessionStorage.leave_leave_day = leave_day;
			sessionStorage.leave_content = content;
			sessionStorage.leave_leave_id = leave_id;
			sessionStorage.leave_approve_id = approve_id;
			sessionStorage.leave_approve_name = approve_name;
			sessionStorage.leave_approve_time = approve_time;
			sessionStorage.leave_approve_avatar = approve_avatar;
			sessionStorage.leave_status = status;
			sessionStorage.leave_apply_time = apply_time;
			sessionStorage.leave_update_time = update_time;
			window.location.href = baseUrl+'/Users/leave_detail';
		});
	}

	//切换头部 
	function change_tab(type){
		if(type==0){
			$('.wait_approval').addClass('add_style').siblings().removeClass('add_style');
			$('#other_content').hide();
			$('#wait_content').show();
		}else{
			$('.access_approval').addClass('add_style').siblings().removeClass('add_style');
			$('#other_content').show();
			$('#wait_content').hide();
		}
	}
	//table切换
	$('.wait_approval,.access_approval').click(function(){
		var type = $(this).attr('type');	
		var is_load = $(this).attr('is_load');
		change_tab(type);
		if(is_load==1){
			return;
		}
		loadPageData(type);
	});
	$('.content').bind('scroll',function(){
		var type = $('.add_style').attr('type');
		var content_h = $(this).height();
		var scroll_h = $('.content').scrollTop();
		var lists_h = $('.wait_on_list').height();
		if(type==1){
			lists_h =  $('.access_list').height();
		}
		if(lists_h==content_h+scroll_h){
			loadPageData(type);
		}
	});
})