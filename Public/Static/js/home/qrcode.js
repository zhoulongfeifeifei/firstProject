$(function(){
	//分享变量
	var share_openid = $('#user_openid').val();
	var sharelink =  base_url+'/Home/Users/my_qrcode?openid='+share_openid;
	var imgUrl = base_url+$('#qrcode_img').attr('src');
	//菜单分享给朋友
	$shareFriends.title = '我的二维码';
	$shareFriends.desc='夜生活不再这么孤独，扫一扫加入吧';
	$shareFriends.link = sharelink;
	$shareFriends.imgUrl = imgUrl;

	//分享到朋友圈
	$shareTimeLine.title='我的二维码';
	$shareTimeLine.link = sharelink;
	$shareTimeLine.imgUrl = imgUrl;

	//分享到qq
	$shareQq = $shareFriends;
	//分享到微博
	$shareWeibo = $shareFriends;
	//分享到qq空间
	$shareQzone = $shareFriends;

	$('#choose_img').click(function(){
		//选择图片
	//	wxChooseImgs(9,dealChooseImgs);
		/*
		预览图片
		var imgs = ['http://pic36.nipic.com/20131217/6704106_233034463381_2.jpg',
				'http://img05.tooopen.com/images/20140604/sy_62331342149.jpg',
				'http://pic41.nipic.com/20140509/4746986_145156378323_2.jpg',
				'http://pic13.nipic.com/20110415/1369025_121513630398_2.jpg'];
		wxViewImgs(imgs);
		*/

		//获取网络状态
		alert($netWorkType);
	});
	/*
	//选择图片回调
	dealChooseImgs = function(imgs){
		//上传图片
		var img1 = imgs[0];
		wxUploadImgs(img1,uploadImgs);
	}
	//上传图片回调
	uploadImgs = function(media_id){
		alert(media_id);
	}

	*/

	getNetWorkType = function(type){
		alert(type);
	}
});