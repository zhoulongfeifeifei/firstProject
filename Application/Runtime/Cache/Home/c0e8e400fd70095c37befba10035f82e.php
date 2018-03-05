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

<link rel="stylesheet" type="text/css" href="/Static/css/home/addteacher.css" />
<link rel="stylesheet" type="text/css" href="/Static/css/home/addclasshour.css" />
<body>
	<div class="teacherinfirmation">
		<ul class="teacherinfirmation-list">
			<li class="teacherinfirmation-li1"><span>机构：星洲琴行(德胜店)</span><span>授课老师Jack</span></li>
			<li>
			<label for="">学员：<input type="text" placeholder="请输入姓名"></label>
			</li>
			<li>
			<label for="">课时：<input type="text" placeholder="请输入课时数(必填)"></label>
			</li>
			<li class="teacherinfirmation-li4"><label for="">年级：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<input type="text" placeholder="一年级"></label>
			</li>
			<li><label for="">性别：
				<img src="/Static/images/home/Pk_woman_default.png" alt="">
				<img src="/Static/images/home/Pk_man_click.png" alt="">
			 </li>
			<li><label for="">手机号码：<input type="text" placeholder="请输入手机号(必填)"></label></li>
			<li><label for=""><input type="text" placeholder="请输入手机号(选填)"></label></li>
			<li class="teacherinfirmation-li2"><label for="">课程：
				<img src="/Static/images/home/Kb_forward.png" alt="">
				<input type="text" placeholder="架子鼓"></label>
			</li>
			<li class="teacherinfirmation-li3">入职时间：
				<img src="/Static/images/home/Pk_date.png" id="workdate">
			</li>
		</ul>
		<div class="information-btn" id="information-btn">
			<div class="information-btn1" style="background: #ff3846">取消</div>
			<div class="information-btn1" style="background: #55c5d5">确定</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="/Static/js/home/addclasshour.js"></script>
</html>