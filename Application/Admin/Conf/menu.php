<?php
return array(
	//后台菜单
	'menu'=>array(
		array(
			'name'=>'广告位管理',
			'rel'=>'advert',
			'lists'=>array(
				array('name'=>'首页轮播','rel'=>'index_slide','href'=>'/admin/Advert?rel=index_slide&type=1'),
				array('name'=>'首页导航','rel'=>'nav_list','href'=>'/admin/Advert?rel=nav_list&type=2'),
			),
		),
		array(
			'name'=>'机构管理',
			'rel'=>'agency',
			'lists'=>array(
				array('name'=>'课程列表','rel'=>'course_lists','href'=>'/admin/Course/'),
				array('name'=>'机构列表','rel'=>'agency_lists','href'=>'/admin/Agency/'),
				array('name'=>'课表','rel'=>'timetable_lists','href'=>'/admin/Course/timetable_lists'),
			),
		),
		array(
			'name'=>'消息管理',
			'rel'=>'wechat_message',
			'lists'=>array(
				array('name'=>'接收消息列表','rel'=>'receive_msg','href'=>'/admin/WechatMessage/'),
				array('name'=>'回复关键词','rel'=>'wechat_keywords','href'=>'/admin/WechatMessage/wechat_keywords'),
				array('name'=>'被动回复设置','rel'=>'revert_lists','href'=>'/admin/WechatMessage/revert_lists'),
			),
		),
		array(
			'name'=>'素材管理',
			'rel'=>'wechat_material',
			'lists'=>array(
				array('name'=>'素材管理','rel'=>'material','href'=>'/admin/WechatMaterial/index'),
			),
		),
		array(
			'name'=>'菜单管理',
			'rel'=>'wechat_menu',
			'lists'=>array(
				array('name'=>'菜单列表','rel'=>'menu_list','href'=>'/admin/wechat/'),
			),
		),
		array(
			'name'=>'用户管理',
			'rel'=>'users',
			'lists'=>array(
				array('name'=>'网站用户','rel'=>'users_lists','href'=>'/admin/Users/'),
				array('name'=>'微信用户','rel'=>'wechat_users','href'=>'/admin/WechatUsers/'),
			),
		),
		array(
			'name'=>'系统管理',
			'rel'=>'system',
			'lists'=>array(
			//	array('name'=>'公众号配置','rel'=>'wechat_set','href'=>'/admin/wechat/set_info'),
				array('name'=>'人员管理','rel'=>'employee','href'=>'/admin/System/employee'),
				array('name'=>'部门管理','rel'=>'department','href'=>'/admin/System/department'),
			),
		),
	),

	//权限
	'permission'=>array(
		//广告位
		'index_slide'=>array(
			'name'=>'广告位管理－－首页轮播图',
			'lists'=>array(
				'add_index_slide'=>'添加轮播图',
				'edit_index_slide'=>'修改轮播图',
				'del_index_slide'=>'删除轮播图',
			),
		),
		'nav_list'=>array(
			'name'=>'广告位管理－－首页导航',
			'lists'=>array(
				'add_nav_list'=>'添加导航广告',
				'edit_nav_list'=>'修改导航广告',
				'del_nav_list'=>'删除导航广告',
			),
		),
		//课程
		'course_llists'=>array(
			'name'=>'机构管理-----课程列表',
			'lists'=>array(
				'add_course'=>'添加课程',
				'edit_course'=>'修改课程',
				'del_course'=>'删除课程',
			),
		),
		//课表
		'timetable_lists'=>array(
			'name'=>'机构管理-----课表',
			'lists'=>array(
				'add_timetable'=>'添加课表',
				'edit_timetable'=>'修改课表',
				'del_timetable'=>'删除课表',
			),
		),
		//机构
		'agency_lists'=>array(
			'name'=>'机构管理-----机构列表',
			'lists'=>array(
				'add_agency'=>'添加机构',
				'edit_agency'=>'修改机构',
				'del_agency'=>'删除机构',
				'agency_course_lists'=>'机构课程列表',
				'add_agency_course'=>'添加机构课程',
				'edit_agency_course'=>'修改机构课程',
				'del_agency_course'=>'删除机构课程',
				'agency_users_lists'=>'机构用户列表',
				'add_agency_users'=>'添加机构用户',
				'edit_agency_users'=>'修改机构用户',
				'del_agency_users'=>'删除机构用户',
			),
		),
		//分类
		'category_lists'=>array(
			'name'=>'分类管理－－分类列表',
			'lists'=>array(
				'add_category'=>'添加分类',
				'edit_category'=>'修改分类',
				'del_category'=>'删除分类',
			),
		),
		//消息
		'receive_msg'=>array(
			'name'=>'消息管理--接收消息列表',
			'lists'=>array(
			//	'del_receive_msg'=>'删除本地接收消息',
			),
		),
		//消息
		'wechat_keywords'=>array(
			'name'=>'消息管理--回复关键词',
			'lists'=>array(
				'add_keywords'=>'添加关键词',
				'edit_keywords'=>'修改关键词',
				'del_keywords'=>'删除关键词',
			),
		),
		//消息
		'revert_lists'=>array(
			'name'=>'消息管理--被动回复设置',
			'lists'=>array(
				'add_revert'=>'添加被动回复',
				'edit_revert'=>'修改被动回复',
				'del_revert'=>'删除被动回复',
			),
		),
		//素材
		'material'=>array(
			'name'=>'消息管理--素材管理',
			'lists'=>array(
				'add_material'=>'添加素材',
				'edit_material'=>'修改素材',
				'del_material'=>'删除素材',
			),
		),
		//菜单
		'menu_list'=>array(
			'name'=>'菜单管理--菜单列表',
			'lists'=>array(
				'add_menu'=>'添加菜单',
				'edit_menu'=>'修改菜单',
				'del_menu'=>'删除菜单',
			),
		),
		//用户列表
		'wechat_users'=>array(
			'name'=>'用户管理--微信用户列表',
			'lists'=>array(
			),
		),
		//用户列表
		'users_lists'=>array(
			'name'=>'用户管理--网站用户管理',
			'lists'=>array(
				'add_users'=>'添加用户',
				'edit_users'=>'修改用户',
				'del_users'=>'删除用户',
			),
		),
		//人员管理
		'employee'=>array(
			'name'=>'系统管理--人员管理',
			'lists'=>array(
				'add_employee'=>'添加人员',
				'edit_employee'=>'修改人员',
				'del_employee'=>'删除人员',
				'add_employee_permission'=>'添加/修改权限',
			),
		),
		//部门管理
		'department'=>array(
			'name'=>'系统管理--部门管理',
			'lists'=>array(
				'add_department'=>'添加部门',
				'edit_department'=>'修改部门',
				'del_department'=>'删除部门',
				'add_department_permission'=>'添加/修改权限',
			),
		),
	),

);
?>