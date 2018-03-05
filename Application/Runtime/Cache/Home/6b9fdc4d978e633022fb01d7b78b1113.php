<?php if (!defined('THINK_PATH')) exit();?><!--导入头信息-->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<meta name="description" content="">
		<title id="title">杭州菲比教育</title>
	</head>
	<link rel="stylesheet" type="text/css" href="/Static/css/home/base.css" />
	<script src="/Static/plugins/Jui/js/jquery-1.7.2.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		//定义全局对象
		$shareFriends = new Object(); //分享朋友
		$shareTimeLine = new Object(); //分享朋友圈
		$shareQq = new Object();//分享到qq
		$shareWeibo = new Object();//分享到微博
		$shareQzone = new Object();//分享到qq空间
		$netWorkType = ''; //网络状态

		openid = '<?php echo $openid;?>'; //用户id
		base_url = 'http://'+window.location.host; 
		wx.config({
			debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
			appId: '<?php echo C("APPID");?>', // 必填，公众号的唯一标识
			timestamp: '<?php echo $timestamp;?>', // 必填，生成签名的时间戳
			nonceStr: '<?php echo $noncestr?>', // 必填，生成签名的随机串
			signature: '<?php echo $sign;?>',// 必填，签名，见附录1
			jsApiList: [
				'checkJsApi',    
				'onMenuShareTimeline',    
				'onMenuShareAppMessage',    
				'onMenuShareQQ',    
				'onMenuShareWeibo',    
				'onMenuShareQZone',
				'hideMenuItems',    
				'showMenuItems',    
				'hideAllNonBaseMenuItem',    
				'showAllNonBaseMenuItem',    
				'translateVoice',    
				'startRecord',    
				'stopRecord',    
				'onRecordEnd',    
				'playVoice',    
				'pauseVoice',    
				'stopVoice',    
				'uploadVoice',    
				'downloadVoice',    
				'chooseImage',    
				'previewImage',    
				'uploadImage',    
				'downloadImage',    
				'getNetworkType',    
				'openLocation',    
				'getLocation',    
				'hideOptionMenu',    
				'showOptionMenu',    
				'closeWindow',    
				'scanQRCode',    
				'chooseWXPay',    
				'openProductSpecificView',    
				'addCard',    
				'chooseCard',    
				'openCard' 
			] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
		});
		wx.ready(function(){
			//获取网络状态
			wx.getNetworkType({
				success: function (res) {
					$netWorkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
				}
			});
		});
	</script>
	<script type="text/javascript" src="/Static/js/home/base.js"></script>

<link rel="stylesheet" type="text/css" href="/Static/css/home/timetable.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/rili.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/base.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/coursearrang.css" />
<body>
	<div class="banner-top">
		<ul class="banner-top-content">
			<li><select class="banner-select">
				<option value="">星洲琴行</option>
				<option value="">星洲琴行1</option>
			</select></li>
			<li><select class="banner-select">
				<option value="">罗小超</option>
				<option value="">星洲琴行</option>
			</select></li>
			<li><img src="/Static/images/home/Pk_date.png" alt="" class="time-img"></li>
		</ul>
	</div>	
	<div class="swiper-container content-kebiao" id="content-center">
	      <div class="swiper-wrapper content-center">  
	      	<div class="swiper-slide content-slide"> 
			<div class="kebiao-center">
				<ul class="kebiao-list">
					<li class="kebiao-li kebiao-li1">
						<ul id="kebiao-list-first">
							<li id="kebiao-li-first" style="background: #fff; border: 0"></li>
							<li>07:00</li>
							<li>08:00</li>
							<li>09:00</li>
							<li>10:00</li>
							<li>11:00</li>
							<li>12:00</li>
							<li>13:00</li>
							<li>14:00</li>
							<li>13:00</li>
						</ul>
					</li>
					<li class="kebiao-li kebiao-li2">
						<ul class="kebiao-li-second">
							<li id="kebiao-li-first" class="kebiao-li-first">周一</li>
							<li class="kebiao-li-nobg"></li>
							<li class="kebiao-li-nobg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-bg">
							</li>
							<li class="kebiao-li-bg">
							</li>
							<li class="kebiao-li-nobg">
								 
							</li>
							<li class="kebiao-li-nobg">
								 
							</li>
							<li class="kebiao-li-nobg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-nobg"></li>
							<li class="kebiao-li-nobg"></li>
						</ul>
					</li>
					<li class="kebiao-li kebiao-li2">
						<ul class="kebiao-li-second">
							<li id="kebiao-li-first">周二</li>
							<li>
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li></li>
							<li>
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li>
							</li>
							<li>
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-bg"> 
							</li>
							<li></li>
							<li></li> 
							<li></li>
						</ul>
					</li>
				</ul>
			</div>	
			</div>  
	      </div>  
	      <!-- 日历 -->
    <div class="aboluo-w-700">
	<div class="aboluo-leftdiv">
		<div class="aboluo-tools">
			<div class="aboluo-calendar-select-year"></div>
			<div class="aboluo-calendar-month">
				<a class="aboluo-month-a-perv" href="javascript:;">&lt; </a>
				<a class="aboluo-month-a-next" href="javascript:;"> &gt;</a>
			</div>
			<input type="button" class="aboluo-toToday" value="返回今天" />
		</div>
		<div class="aboluo-rilidiv">
			<table class="aboluo-rilitable" cellspacing="0" cellpadding="0" >
				<thead class="aboluo-rilithead">
					<tr>
						<th>周一</td>
						<th>周二</td>
						<th>周三</td>
						<th>周四</td>
						<th>周五</td>
						<th>周六</td>
						<th>周日</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	 <div class="aboluo-rightdiv">
		<p class="aboluo-xssj"><p>
		<p class="aboluo-currday"></p>
		<p class="aboluo-ssjjr"></p>
		<p class="aboluo-xsmx"></p>
	</div> 
	<div class="aboluo-ok">完成</div>
</div>
 <div class="zezhao2"></div>
  <div class="zezhao1"></div>
  <div class="course">
    	<p>课程详情</p>
    	<ul class="course-list">
    		<li>上课时间：<span>14:15-15:00</span></li>
    		<li>课程名称:<span>架子鼓</span></li>
    		<li>班级名称：<span>架子鼓_赵红雨</span></li>
    		<li>授课老师：<span>李晨</span></li>
    		<li>开班时间：<span>2016-11-16</span></li>
    		<li>已上课时间：<span>1小时</span></li>
    		<li>在读学员：<span>赵红雨</span></li>
    	</ul>
    	<ul class="course-list2">
    		<li id="course-li">点名</li>
    		<li>请假</li>
    		<li>调课</li>
    	</ul>
    </div>
</body>
<script type="text/javascript" src="/Static/js/home/ri.js"></script>
<script type="text/javascript" src="/Static/js/home/coursearrang.js"></script>
<script type="text/javascript" src="/Static/js/common/zepto.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script>
</html>