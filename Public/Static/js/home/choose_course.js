$(function(){
	//选择月份
	$('#select_mon,#select_year').change(function(){
		var y = $('#select_year').val();
		var m = $('#select_mon').val();
		var days = getDays(y,m);
		var html = '';
		var class_html = '';
		var src_select_day = $('#select_day').val();
		for(var i=1;i<=days;i++){
			var is_select = '';
			if(src_select_day==i){
				is_select = 'selected';
			}
			html+='<option value="'+i+'" '+is_select+'>'+i+'</option>';
			class_html+='<li></li>';
		}
	//	$('#select_day').html(html);
		//$('#mySwipe').html(class_html);

	});

	$('.class_condition').click(function(){
		$('.condition_lists').parent().toggleClass('none');
	});

	$('#select_day').change(function(){
		var d = $(this).val();
		var day_index = $('.class_day_'+d).attr('data-index');
		swiper.swipeTo(day_index);
	});

	$('.class_day').find('li').click(function(e){
		$('.detail_content').parent().removeClass('none');
	});

	$('.detail_content,.condition_lists').click(function(e){
		if(e&&e.stopPropagation){//非IE
			e.stopPropagation();
		}else{//IE
			window.event.cancelBubble=true;
		}
	});
	$('.class_detail').click(function(){
		$('.class_detail').addClass('none');
	});

	//获取月份天数
	function getDays(Year,Month){
		var d = new Date(Year,Month,0);
		return d.getDate();
	}

	var index = 0;
	$('.class_day').each(function(){
		var today = $(this).attr('today');
		if(today==1){
			index = $(this).attr('data-index');
		}
	});

	var swiper = new Swiper('#mySwipe', {
		autoplay: 0,
		speed:800,
		initialSlide:index,
		continuous: true,
		disableScroll:true,
	});

});