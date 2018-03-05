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

<link rel="stylesheet" type="text/css" href="/Static/css/home/kebiao.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/animate.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/swiper-3.3.1.min.css"/>
<link rel="stylesheet" type="text/css" href="/Static/css/home/base.css" />
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
			<li><select class="banner-select">
				<option value="">杨小明</option>
				<option value="">星洲琴行</option>
			</select></li>
			<li><img src="/Static/images/home/Home_kb.png" alt=""></li>
		</ul>
	</div>
	<div class="swiper-container content-kebiao">
	      <div class="swiper-wrapper content-center">  
	      	<div class="swiper-slide content-slide"> 
			<div class="kebiao-center">
				<p>2016-11-14~2016-11-20</p>
				<ul class="kebiao-list">
					<li class="kebiao-li kebiao-li1">
						<ul id="kebiao-list-first">
							<li id="kebiao-li-first"></li>
							<li>07:00</li>
							<li>08:00</li>
							<li>09:00</li>
							<li>10:00</li>
							<li>11:00</li>
							<li>12:00</li>
							<li>13:00</li>
							<li>14:00</li>
						</ul>
					</li>
					<li class="kebiao-li kebiao-li2">
						<ul class="kebiao-li-second">
							<li id="kebiao-li-first">周四 11/17</li>
							<li class="kebiao-li-nobg"></li>
							<li class="kebiao-li-bg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-bg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-nobg">
							</li>
							<li class="kebiao-li-bg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-nobg">
								 
							</li>
							<li class="kebiao-li-bg">
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li class="kebiao-li-nobg"></li>
						</ul>
					</li>
					<li class="kebiao-li kebiao-li2">
						<ul class="kebiao-li-second">
							<li id="kebiao-li-first">周五 11/18</li>
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
							<li>
								<span>课程名称：小提琴</span>
								<span>机构：星洲棋行</span>
								<span>学员：Cincy</span>
							</li>
							<li></li>
							<li></li>
						</ul>
					</li>
				</ul>
			</div>	
			</div>  
	      </div> 
	       <div class="swiper-button-prev swiper-button-black" id="content-btn"></div> 
		   <div class="swiper-button-next swiper-button-black" id="content-btn" ></div> 
    </div>  
    
</body>
<!-- <script type="text/javascript" src="/Static/js/home/ri.js"></script>
 --><script type="text/javascript" src="/Static/js/home/kebiao.js"></script>
<script type="text/javascript" src="/Static/js/common/zepto.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper-3.3.1.jquery.min.js"></script>
<script type="text/javascript" src="/Static/js/common/swiper.animate1.0.2.min.js"></script>
</html>