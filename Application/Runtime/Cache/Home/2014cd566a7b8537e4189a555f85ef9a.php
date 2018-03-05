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
	
<link rel="stylesheet" href="/Static/css/home/base.css" />
<link rel="stylesheet" href="/Static/css/home/identification.css" />
<body>
	
	<!-- <div class="all-zezhao">
		<h2 class="tishi">提示</h2>
		<div class="zezhao-content">
			<p>意外错误，操作无法完成！请重新输入！请重新输入！</p>
			<div class="zezhao-btn">确定</div>
		</div>
	</div> -->
	<div class="zezhao">
		<div class="tanchu">
	 	<div class="sousuo">
	 		<!-- <img src="/Static/images/home/Id_search_bt.png" alt=""> -->
	 		<input type="search" name="search" results id="search" value="" placeholder="请输入关键词查询" />
	 	</div>
	 	<div class="xuanze">
	 		<ul class="xuanze-list" id="xuanze-list">
	 		</ul>
	 	</div>
	 	<div class="btn-1">
	 		<span id="btn-cancel">取消</span><span id="btn-do">确定</span>
	 	</div>
	 </div>
	</div>
	 <div class="banner">
	 	 <div class="banner-bg">
	 	 	<img src="/Static/images/home/Home_qj.png" alt="" id="banner-img">
	 	 	<span>身份认证</span>
	 	 </div>
	 </div>
	  <div class="form-1"><span>真实姓名</span><input type="text" id="true_name" placeholder="请输入您的真实姓名"></div>
	  <div class="form-1"><span>联系方式</span><input type="text" id="mobile" placeholder=""></div>
	  <div class="form-1"><input type="text" id="sms_code"/><button id="btn-yanzheng">获取验证码</button></div>
	  <div class="form-2">
	   <div class="form-3"><img src="/Static/images/home/Id_mechanism.png" alt=""><span>所在机构</span></div>
	   <div class="form-4">
	   	<div class="qihang" id="qihang">点击选择机构</div>
	   	<ul id="qihang-list">
	   	</ul>
	   	<div class="btn">
	   		<button id="cancel">取消</button>
	   		<button id="doit">确定</button>
	   	</div>
	   </div>
	  </div>
	   <div class="tijiao">
	   		<span id="tijiao-cancel">取消</span>
	   		<span id="tijiao-do">提交</span>
	   </div> 
	  
</body>
<script type="text/javascript" src="/Static/js/home/base.js"></script>
<script type="text/javascript" src="/Static/js/home/identification.js"></script>
</html>