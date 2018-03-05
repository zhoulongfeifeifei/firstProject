$(function(){
	init();
	//初始化页面
	function init(){
		//获取头像
		$('#title').text('单课请假');
	};
	$('.list-person').click(function(){
		$('.getOut').show();
	});
	$('.approver-cancel').click(function(){
		$('.getOut').hide();
	})
})