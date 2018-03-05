baseUrl = 'http://system.phebe-edu.com/';
apiUrl = baseUrl+'/Api/';
wx.ready(function(){
	//隐藏分享QQ空间按钮
	wx.hideMenuItems({
		menuList: ['menuItem:share:QZone'] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
	});
	//分享朋友
	wx.onMenuShareAppMessage({
		title: $shareFriends.title, // 分享标题
		desc: $shareFriends.desc, // 分享描述
		link:$shareFriends.link, // 分享链接
		imgUrl: $shareFriends.imgUrl,
		type: '', // 分享类型,music、video或link，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () { 
		// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
		// 用户取消分享后执行的回调函数
		}
	});	

	//分享朋友圈
	wx.onMenuShareTimeline({
		title: $shareTimeLine.title, // 分享标题
		link: $shareTimeLine.link, // 分享链接
		imgUrl: $shareTimeLine.imgUrl, // 分享图标
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	}); 

	//分享到qq
	wx.onMenuShareQQ({
		title: $shareQq.title, // 分享标题
		desc: $shareQq.desc, // 分享描述
		link: $shareQq.link, // 分享链接
		imgUrl: $shareQq.imgUrl, // 分享图标
		success: function () { 
		// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
		// 用户取消分享后执行的回调函数
		}
	});

	//分享到微博
	wx.onMenuShareWeibo({
		title: $shareWeibo.title, // 分享标题
		desc: $shareWeibo.desc, // 分享描述
		link: $shareWeibo.link, // 分享链接
		imgUrl: $shareWeibo.imgUrl, // 分享图标
		success: function () { 
		// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
		// 用户取消分享后执行的回调函数
		}
	});	

	//分享到qq空间
	wx.onMenuShareQZone({
		title: $shareQzone.title, // 分享标题
		desc: $shareQzone.desc, // 分享描述
		link: $shareQzone.link, // 分享链接
		imgUrl: $shareQzone.imgUrl, // 分享图标
		success: function () { 
		// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
		// 用户取消分享后执行的回调函数
		}
	});

	/************************************************ 封装微信js接口 ************************************************************/

	/*
	* 选择图片接口
	* cnt  图片数量
	* backfunc  回调方法
	*/
	wxChooseImgs = function(cnt,backfunc){
		var nums = cnt ? cnt : 9;
		wx.chooseImage({
			count: nums, // 默认9
			sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				backfunc(localIds);
			}
		});
	}

	/*
	* 预览图片
	* imgs 图片数组
	*/
	wxViewImgs = function(imgs){
		wx.previewImage({
			current: imgs[0], // 当前显示图片的http链接
			urls: imgs // 需要预览的图片http链接列表
		});
	}

	/*
	* 上传图片到微信服务器
	* img_id 需要上传的图片的本地ID，由chooseImage接口获得
	*/

	wxUploadImgs = function(img_id,backfunc){
		wx.uploadImage({
			localId: img_id, // 需要上传的图片的本地ID，由chooseImage接口获得
			isShowProgressTips: 1, // 默认为1，显示进度提示
			success: function (res) {
				var serverId = res.serverId; // 返回图片的服务器端ID
				backfunc(serverId);
			}
		});
	}

	//隐藏微信菜单
	wxMenuHide = function(){
		wx.hideOptionMenu();
	}

	//显示菜单
	wxMenuShow = function(){
		wx.showOptionMenu();
	}

	//关闭当前网页接口
	wxCloseWindows = function(){
		wx.closeWindow();
	}

	/*
	* 隐藏菜单按钮
	* items 按钮名 数组  传播类 保护累
	*/
	wxMenuItemsHide = function(items){
		wx.hideMenuItems({
			menuList: items // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
		});
	}

	//显示菜单按钮
	wxMenuItemsShow = function(items){
		wx.showMenuItems({
			menuList: items // 要显示的菜单项，所有menu项见附录3
		});
	}

	//隐藏所有非基础按钮
	wxMenuBaseItemsHide = function(){
		wx.hideAllNonBaseMenuItem();
	}

	//显示所有接口按钮
	wxMenuItemsAllShow = function(){
		wx.showAllNonBaseMenuItem();
	}

	/*
	*微信支付
	* data 服务端返回预支付信息
	* backfunc  回调
	*/
	wxPay = function(data,backfunc){
		wx.chooseWXPay({
			timeStamp: data.timestamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
			nonceStr: data.noncestr, // 支付签名随机串，不长于 32 位
			package: data.prepay_id, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
			signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
			paySign: data.sign, // 支付签名
			success: function (res) {
				// 支付成功后的回调函数
				backfunc(res);
			}
		});
	}
});



//获取文档高度
function getDocumentTop() {
	var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
	if (document.body) {
		bodyScrollTop = document.body.scrollTop;
	}
	if (document.documentElement) {
		documentScrollTop = document.documentElement.scrollTop;
	}
	scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop; 
	return scrollTop;
}



//可视窗口高度
function getWindowHeight () {
	var windowHeight = 0;    if (document.compatMode == "CSS1Compat") {
		windowHeight = document.documentElement.clientHeight;
	} else {
		windowHeight = document.body.clientHeight;
	}
	return windowHeight;
}


//滚动条滚动高度
function getScrollHeight () {
	var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
	if (document.body) {
		bodyScrollHeight = document.body.scrollHeight;
	}
	if (document.documentElement) {
		documentScrollHeight = document.documentElement.scrollHeight;
	}
	scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;  
	return scrollHeight;

}

function showMessage(msg){
	if($('.zezhao-error').text()){
		return;
	}
	msg = msg ? msg : '系统错误，请稍后重试！';
	var html = '<div class="zezhao-error">'+msg+'</div>';
	$('body').append(html);
	setTimeout(function(){
		$('.zezhao-error').fadeOut(2000);
	},700);
	setTimeout(function(){
		$('.zezhao-error').remove();
	},2700);

}
function showError(msg){
	if ($('.all-zezhao')) {
		return;
	}
	msg =msg?msg : '意外错误，操作无法完成！请重新输入！请重新输入！';
	var html='<div class="all-zezhao"><h2 class="tishi">提示</h2><div class="zezhao-content"><p>'+msg+' </p><div class="zezhao-btn">确定</div></div></div>'
}
