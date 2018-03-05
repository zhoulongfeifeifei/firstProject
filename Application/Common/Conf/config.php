<?php
return array(
	//'配置项'=>'配置值'
	'LOAD_EXT_CONFIG'=>array('database','subject','wechat','emoji','wechat_error'),
	//允许访问模块
	'MODULE_ALLOW_LIST'=>array('Home','Admin','Api','Wechat'),
	//默认访问模块
	'DEFAULE_MODULE'      =>  'Home',
	//模版文件后嘴
	'TMPL_TEMPLATE_SUFFIX' => '.php',
	//url伪静态后嘴
	'URL_HTML_SUFFIX'      => '.html',
	'STATIC_PATH' => '/Static/',

	//是否显示接口文档
	'SHOW_API'=>true,
	//签名有效时间
	"SIGN_TIME"=>20,

	//阿里大于 短信服务key
	'ALIDAYU_APP_KEY'=>'23540384',
	//阿里大于 短信服务secret
	'ALIDAYU_APP_SECRET'=>'dde763b5c22f879e17a8b1da9bcec040',
	//sign_name
	'ALIDAYU_SIGN_NAME'=>'杭州菲比教育',
	'ALIDAYU_SMS_CODE'=>'SMS_27580136',

	//开启子域名
	'APP_SUB_DOMAIN_DEPLOY'=>1,
	'APP_SUB_DOMAIN_RULES'=>array(
		'admin.no1987.com'=>'Admin',
		'wechat.no1987.com'=>'Wechat',
	),

	//接口域名
	'API_URL'=>'http://www.phebeloc.com/Api/',
);
