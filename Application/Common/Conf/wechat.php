<?php 
return array(
	'TOKEN'=>'tcwweixin',
	'APPID'=>'wx14973aeaba15687e',//,
	'APP_SECRET'=>'540a2a4531cb7a54a847c58a6bf5cce8',//,


	//获取access_token
	'ACCESS_TOKEN_API'=>'https://api.weixin.qq.com/cgi-bin/token',
	//添加菜单
	'CREATE_MENU_API'=>'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=',
	//微信上传临时文件接口
	'TEMP_MATERIAL_API'=>'https://api.weixin.qq.com/cgi-bin/media/upload',
	//获取用户信息
	'USER_INFO_API'=>'https://api.weixin.qq.com/cgi-bin/user/info',
	//获取临时素材
	'GET_TEMP_MATERIAL_API' => 'https://api.weixin.qq.com/cgi-bin/media/get',

	//客服发送消息
	'SERVICE_SEND_API'=>'https://api.weixin.qq.com/cgi-bin/message/custom/send',

	//二维码接口
	'QRCODE_API'=>'https://api.weixin.qq.com/cgi-bin/qrcode/create',
	//获取二维码
	'GET_QRCODE_API'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode',

);

?>