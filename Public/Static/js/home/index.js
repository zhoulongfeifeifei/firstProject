$(function(){

function slider_img(){
	var mySwiper = new Swiper ('.swiper-container', { 
		direction: 'horizontal',loop:true,autoplay:8000,
		pagination: '.swiper-pagination',
		onInit: function(swiper){ 
		swiperAnimateCache(swiper);
		//初始化完成开始动画
		swiperAnimate(swiper);             
		}, 
		onSlideChangeEnd: function(swiper){
			swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
		} 

	}) 
}

init();
	   //首页
	function init(){
		$.ajax({
			type: "POST",
			url: apiUrl+'Index',
			data: {openid:openid},
			dataType: "json",
			success: function(data){
				//未认证
				// console.log(data.week)
				if(data.status==-1){
					sessionStorage.avatar = data.avatar;
					window.location.href = baseUrl+'/Index/identification';
				}else if(data.status==1){
					var slider_lists = data.slider_lists;
					var nav_lists = data.nav_lists;
					$('#main-shijian').html(data.now_date);
					$('#main-day').html(data.week+'      '+data.now_time);
					var slider_html = '';
					$(slider_lists).each(function(i,v){
						slider_html+='<div class="swiper-slide banner-bg">\
							<div class="banner-conten"><a href="'+v.skip_content+'"><img src="'+v.img+'" alt=""></a></div>\
							<div class="banner-detail">'+v.desc+'</div>\
						</div>';
					});
					$('.banner-img').html(slider_html);
					slider_img();

					//加载导航
					var nav_html = '';
					$(nav_lists).each(function(i,v){
						nav_html+='<a href="'+v.skip_content+'"><li><img src="'+v.img+'" alt=""><span>'+v.name+'</span></li></a>';
					});
					$('.maint-list').html(nav_html);
				}else{
					showMessage(data.msg);
				}
			}
		});
	}
});    