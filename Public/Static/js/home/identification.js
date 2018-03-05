$(function(){
	init();

	//初始化页面
	function init(){
		//获取头像
		var avatar = sessionStorage.avatar;
		$('#banner-img').attr('src',avatar);
		$('#title').text('杭州菲比教育身份认证');
	}

	//验证码倒计时
	var wait_time = 60; 
	function set_time(o) { 
		if (wait_time == 0) { 
			$(o).attr('disabled',false);
			$(o).text('获取验证码');
			wait_time = 60; 
		} else { 
			$(o).attr('disabled',true);
			var value="重新发送(" + wait_time + ")"; 
			$(o).text(value);
			wait_time--; 
			setTimeout(function() { 
				set_time(o);
			}, 1000) 
		} 
	} 

	//获取验证码
	$('#btn-yanzheng').click(function(){
		var mobile = $('#mobile').val();
		var true_name = $('#true_name').val();
		var patt = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|170[0-9]{8}$|14[0-9]{1}[0-9]{8}$/;
		if(!true_name){
			showMessage('请输入真实姓名！');
		}else if(!mobile){
			showMessage('请输入电话号码！');
		}else if(!patt.test(mobile)){
			showMessage('手机号码格式错误！');
		}else{
			send_sms(this,mobile,true_name);
		}
	});

	function send_sms(obj,mobile,name){
		set_time(obj);
		$.ajax({
			type: "POST",
			url: apiUrl+'Index/send_sms',
			data: {mobile:mobile,name:name},
			dataType: "json",
			success: function(data){
				if(data.status==1){
					showMessage('短信发送成功！');
				}else{
					showMessage(data.msg);
				}
			}
		});
	}

	//选择机构
	$('#qihang').click(function(){
		// $('.tanchu').show();
		 $('.zezhao').show();
		search_agency();
	});

	//搜索机构
	$('#search').bind('input',function(){
		var keyword = $(this).val();
		search_agency(keyword);
	});

	//搜索机构
	function search_agency(keyword){
		$.ajax({
			type: "POST",
			url: apiUrl+'Index/get_agency_lists',
			data: {name:keyword,page:1},
			dataType: "json",
			success: function(data){
				var html = '';
				if(data.status==1){
					if(data.lists.length>0){
						$(data.lists).each(function(i,v){
							html+='<li agencyid="'+v.id+'"><span>'+v.name+'</span><img src="/Static/images/home/Id_default.png"></li>';
						});
					}else{
						html='<span>未搜索到相关机构！</span>';
					}
				}else{
					html='<span>搜索失败！</span>';
				}
				$('#xuanze-list').html(html);
				select_agency();
			}
		});
	}

	//选择机构
	 function select_agency(){
	 	$('.xuanze-list').find('li').click(function(){
	 		var agency_id = $(this).attr('agencyid');
	 		var is_selected = $(this).attr('is_selected');
	 		if(is_selected==1){
	 			$(this).attr('is_selected',0);
	 			$(this).find('img').attr('src','/Static/images/home/Id_default.png');
	 		}else{
	 			$(this).attr('is_selected',1);
	 			$(this).find('img').attr('src','/Static/images/home/Id_selected.png');
	 		}
	 	});
	 }

	 //弹出层关闭
	 $('#btn-cancel').click(function(){
	 	//$('.tanchu').hide();
	 	$('.zezhao').hide();
	 });

	 //弹出层确认
	 $('#btn-do').click(function(){
	 	var ag_ids = '';
	 	var html = '';
	 	$('.xuanze-list').find('li').each(function(i,v){
	 		if($(v).attr('is_selected')==1){
	 			ag_ids+=$(v).attr('agencyid')+',';
	 			html+='<li agencyid="'+$(v).attr('aggencyid')+'">'+$(v).find('span').text()+'</li>';
	 		}
	 	});
	 	$('#qihang-list').html(html);
	 	$('#qihang-list').attr('ag_ids',ag_ids);
	 	//$('.tanchu').hide();
	 	$('.zezhao').hide();
	 });

	 //关闭当前页面
	 $('#tijiao-cancel').click(function(){
	 	wxCloseWindows();
	 });

	 //提交认证
	 $('#tijiao-do').click(function(){
	 	var mobile = $('#mobile').val();
		var true_name = $('#true_name').val();
		var sms_code = $('#sms_code').val();
		var ag_ids = $('#qihang-list').attr('ag_ids');
		var patt = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|170[0-9]{8}$|14[0-9]{1}[0-9]{8}$/;
		if(!true_name){
			showMessage('请输入真实姓名！');
		}else if(!mobile){
			showMessage('请输入电话号码！');
		}else if(!patt.test(mobile)){
			showMessage('手机号码格式错误！');
		}else if(!sms_code){
			showMessage('请输入短信验证码！');
		}else if(!ag_ids){
			showMessage('请选择机构！');
		}else{
			user_authentification(true_name,mobile,sms_code,ag_ids);
		}
	 });

	 //用户认证
	  function user_authentification(true_name,mobile,sms_code,ag_ids){
	  	$.ajax({
			type: "POST",
			url: apiUrl+'Index/authentification',
			data: {name:true_name,mobile:mobile,code:sms_code,ag_ids:ag_ids,openid:openid},
			dataType: "json",
			success: function(data){
				if(data.status==1){
					showMessage('认证成功！');
					setTimeout(function(){
						window.location.href= baseUrl;
					},800);
				}else{
					showMessage(data.msg);
				}
				
			}
		});
	  }

});	