$(function(){
	var leave_ag_name=sessionStorage.leave_ag_name;
	var leave_user_avatar=sessionStorage.leave_user_avatar;
	var leave_user_name=sessionStorage.leave_user_name;
	var leave_leave_type=sessionStorage.leave_leave_type;
	var leave_start_time=sessionStorage.leave_start_time;
	var leave_end_time=sessionStorage.leave_end_time;
	var leave_leave_day=sessionStorage.leave_leave_day;
	var leave_content=sessionStorage.leave_content;
	var leave_leave_id=sessionStorage.leave_leave_id;
	var leave_approve_id=sessionStorage.leave_approve_id;
	var leave_approve_name=sessionStorage.leave_approve_name;
	var leave_approve_time=sessionStorage.leave_approve_time;
	var leave_approve_avatar=sessionStorage.leave_approve_avatar;
	var leave_status=sessionStorage.leave_status;
	var leave_apply_time=sessionStorage.leave_apply_time;
	var leave_update_time=sessionStorage.leave_update_time;

	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text(leave_user_name+'的请假');
		fill_content();
	};

	function fill_content(){
		var status_name = '等待审批';
		var img_name = 'Sp_complete';
		if(leave_status==1){
			status_name = '通过';
			img_name = 'Sp_complete';
		}else if(leave_status==2){
			status_name = '拒绝';
			img_name = 'Sp_complete';
		}else if(leave_status==3){
			status_name='已撤销';
			img_name = 'Sp_complete';
		}
		var user_html = '<ul>\
					<li><img src="'+leave_user_avatar+'" alt="" class="head_portrait"></li>\
					<li class="head_name">\
						<p>'+leave_user_name+'</p>\
						<a href="#" id="status_name">'+status_name+'</a>\
					</li>\
				</ul>';
		$('.leave_header').html(user_html);
		var html = '<li>所在机构：<span>'+leave_ag_name+'</span></li>\
				<li>请假类型：<span>'+leave_leave_type+'</span></li>\
				<li>开始时间：<span>'+leave_start_time+'</span></li>\
				<li>结束时间：<span>'+leave_end_time+'</span></li>\
				<li>请假天数：<span>'+leave_leave_day+'</span></li>\
				<li>请假是由：<span>'+leave_content+'</span></li>';

		$('.leave_list').html(html);

		var detail_html ='<div class="content_left">\
					<img src="/Static/images/home/Sp_complete.png" alt="" class="complete_img">\
				</div>\
				<div class="content_right">\
					<ul>\
						<li><img src="'+leave_user_avatar+'" alt="" class="head_portrait1"></li>\
						<li class="content_head_name">\
							<p>'+leave_user_name+'</p>\
							<a href="#">等待审批</a>\
						</li>\
						<li class="content_time">'+leave_apply_time+'</li>\
					</ul>\
				</div>	';
		if(leave_status==1 || leave_status==20){
			detail_html+='<div class="load_on"></div>\
					<div class="content_left">\
							<img src="/Static/images/home/'+img_name+'.png" alt="" class="complete_img">\
						</div>\
						<div class="content_right">\
							<ul>\
								<li><img src="'+leave_approve_avatar+'" alt="" class="head_portrait1"></li>\
								<li class="content_head_name">\
									<p>'+leave_approve_name+'</p>\
									<a href="#">'+status_name+'</a>\
								</li>\
								<li class="content_time">'+leave_approve_time+'</li>\
							</ul>\
						</div>	';
		}else if(leave_status==3){
			detail_html+='<div class="load_on"></div>\
					<div class="content_left">\
							<img src="/Static/images/home/'+img_name+'.png" alt="" class="complete_img">\
						</div>\
						<div class="content_right">\
							<ul>\
								<li><img src="'+leave_user_avatar+'" alt="" class="head_portrait1"></li>\
								<li class="content_head_name">\
									<p>'+leave_user_name+'</p>\
									<a href="#">'+status_name+'</a>\
								</li>\
								<li class="content_time">'+leave_update_time+'</li>\
							</ul>\
						</div>	';
		}
		$('.content').html(detail_html);
	}


	$('#btn-agree,#btn-reject,#btn-repeal').click(function(){
		var type = $(this).attr('type');
		var is_click = $(this).attr('is_click');
		if(is_click==1){
			showMessage('无法操作！');
			return;
		}
		$.ajax({
			url:apiUrl+"Users/edit_leave",
			type:"POST",
			data:{openid:openid,type:type,leave_id:leave_leave_id},
			dataType:"json",
			success:function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					showMessage(data.msg);

					var status_name = '已撤销';
					if(data.type!=3){
						status_name = data.type==1 ? '通过' : '拒绝';
					}
					var html ='<div class="load_on"></div>\
						<div class="content_left">\
								<img src="/Static/images/home/Sp_complete.png" alt="" class="complete_img">\
							</div>\
							<div class="content_right">\
								<ul>\
									<li><img src="'+(data.type!=3 ? data.approve_avatar : leave_user_avatar)+'" alt="" class="head_portrait1"></li>\
									<li class="content_head_name">\
										<p>'+(data.type!=3 ? data.approve_name : leave_user_name)+'</p>\
										<a href="#">'+status_name+'</a>\
									</li>\
									<li class="content_time">'+data.time+'</li>\
								</ul>\
							</div>	';
					$('.content').append(html);
					$('#status_name').text(status_name);
					$(this).attr('is_click',1);

					sessionStorage.leave_status = data.type;
					if(data.type!=3){
						sessionStorage.leave_approve_name = data.approve_name;
						sessionStorage.leave_approve_avatar = data.approve_acatar;
						sessionStorage.leave_apply_time = data.time;
					}else{
						sessionStorage.leave_update_time = data.time;
					}
				}else{
					showMessage(data.msg);
				}
			}
		});
	});


})