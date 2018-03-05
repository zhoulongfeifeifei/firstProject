$(function(){

	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('老师列表');
		//老师列表
		get_teacher_lists();
		//搜索监听
		search_teacher();
		//添加页面
		$('#banner-img').click(function(){
			window.location.href=baseUrl+'/Users/add_teacher';
		});
	}

	function get_teacher_lists(keywords){
		var ag_id = sessionStorage.course_ag_id ? sessionStorage.course_ag_id : 0;
		
		$.ajax({
			type: "POST",
			url: apiUrl+'Users/get_teacher_lists',
			data: {ag_id:ag_id,openid:openid,keywords:keywords},
			dataType: "json",
			success: function(data){
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var lists = data.lists;
					var html = '';
					if(lists.length>0){
						$(lists).each(function(i,v){
							var sex_img = 'Pk_manlabel';
							sex_img = v.sex==1 ? 'Pk_manlabel' : 'Pk_womanlabel';
							html+='<li teacher_id="'+v.id+'">\
									<span class="teacher-skill">'+v.course_name+'</span>\
									<span class="teacher-name">'+v.name+'</span>\
									<img src="/Static/images/home/'+sex_img+'.png" alt="">\
									<span class="teacher-call">'+v.mobile+'</span>\
								</li>';
						});
					}else{
						showMessage('没有任何数据！');
					}
					$('#teacher_lists').html(html);
					click_back();
				}else if(data.status==2){
					showMessage(data.msg);
					window.history.go(-1); 
				}else{
					showMessage(data.msg);
				}
			}
		});
	}

	//点击选中返回
	function click_back(){
		$('#teacher_lists').find('li').click(function(){
			window.history.go(-1); 
		});
	}

	function search_teacher(){
		$('#search-teacher').bind('input',function(){
			var keywords = $(this).val();
			get_teacher_lists(keywords);
		});
	}


})