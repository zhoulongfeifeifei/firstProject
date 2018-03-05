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
		<title id="title">杭州非比教育身份认证</title>
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
		alert(openid);
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

<link rel="stylesheet" media="all and (min-width:360px) and (max-width:720px)" href="/Static/css/home/identification.css" />	
<body>
	  <div><img src="/Static/images/home/Id_banner.png" alt=""></div>
</body>
</html>