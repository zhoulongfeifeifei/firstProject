$(function(){

	var ag_id = sessionStorage.course_ag_id ? sessionStorage.course_ag_id : 0;
	var ag_name = sessionStorage.course_ag_name ? sessionStorage.course_ag_name : '';
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('新增老师');
		$('#agency_name').text('机构：'+ag_name);
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
		$('.womansex').click(function(){
			var is_select = $(this).attr('is_select');
			if(is_select!=1){
				$(this).attr('is_select',1);
				$(this).attr('src','/Static/images/home/Pk_woman_click.png');
				$('.mansex').attr('is_select',0);
				$('.mansex').attr('src','/Static/images/home/Pk_man_default.png');
			}
		});

		add_teacher();
	}

	function add_teacher(){
		$('#sureBtn').click(function(){
			var teacher_name = $('#teacher_name').val();
			var mobile = $('#mobile').val();
			var tel_phone = $('#tel_phone').val();
			var mansex = $('.mansex').attr('is_select');
			var womansex = $('.womansex').attr('is_select');
			var sex = mansex ==1 ? 1 : 2;
			var start_time = $('#workdate').val();
			var course_id =0;

			var patt = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|170[0-9]{8}$|14[0-9]{1}[0-9]{8}$/;
			$('.course_select_img').each(function(i,v){
				if($(v).attr('is_selected')==1){
					course_id = $(v).attr('course_id');
				}
			});
			
			if(!teacher_name){
				showMessage('请输入姓名！');
			}else if(!mobile){
				showMessage('请输入手机号码！!');
			}else if(!course_id){
				showMessage('请选择课程！');
			}else{
				if(!patt.test(mobile)){
					showMessage('手机号码格式错误！');
					return;
				}
				$.ajax({
					type: "POST",
					url: apiUrl+'Users/add_teacher',
					data: {ag_id:ag_id,openid:openid,name:teacher_name,sex:sex,mobile:mobile,tel_phone:tel_phone,course_id:course_id,start_time:start_time},
					dataType: "json",
					success: function(data){
						showMessage(data.msg);
						if(data.status==-1){
							sessionStorage.avatar = data.avatar;
							window.location.href = baseUrl+'/Index/identification';
						}else if(data.status==1){
							window.history.go(-1); 
						}else if(data.status==2){
							window.history.go(-1); 
						}
					}
				});
			}

		});
	}


	
	//加载课程列表
	$('.teacherinfirmation-li2').click(function(){
		if($('.courselist-list').html().length<50){
			get_agency_course();
		}
		$('.courselist').show();
		$('.zezhao').show();
	})

	function get_agency_course(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Course/get_agency_course',
			data: {ag_id:ag_id,openid:openid},
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
	}
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
		$('#workdate').val(select_time);
	});
	
})
