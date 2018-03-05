<?php
//j接口文档配置
return array(
	'api'=>array(
			array(
				'title'=>'基础url：'.C('API_URL'),
				'msg'=>array(
					array(
						'time'=>'2016/11/23',
						'code'=>1,
						'content'=>array(
							'1、发送短信接口',
							'2、机构列表／搜索机构列表',
							'3、认证',
							'4、首页',
							'5、获取课表'
						),
					),
					array(
						'time'=>'2016/11/29',
						'code'=>1,
						'content'=>array(
							'5、获取课表'
						),
					),
					array(
						'time'=>'2016/11/30',
						'code'=>0,
						'content'=>array(
							'6、获取机构下老师列表'
						),
					),
					
				),
				'api_arr'=>array(
					array(
						'test_url'=>C('API_URL').'/Index/send_sms',
						'update_time'=>'20161123',
						'name'=>'1、发送验证码',
						'url'=>'Index/send_sms',
						'type'=>'POST',
						'params'=>array(
							'mobile'=>'手机号码',
							'name'=>'真实姓名',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败',
							'msg'=>'状态吗对应信息',
						),
						'back_eg'=>'{"status":1,"msg":"\u53d1\u9001\u6210\u529f\uff01"}',
					),
					array(
						'test_url'=>C('API_URL').'Index/get_agency_lists',
						'update_time'=>'20161123',
						'name'=>'2、机构列表／搜索机构列表',
						'url'=>'Index/get_agency_lists',
						'type'=>'POST',
						'params'=>array(
							'name'=>'搜索机构时',
							'page'=>'页码 默认1',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败',
							'lists'=>array(
								'id'=>'机构id',
								'name'=>'机构名称',
							),
						),
						'back_eg'=>'{"status":1,"lists":[{"id":"3","name":"\u6d4b\u8bd5\u673a\u67842"},{"id":"2","name":"\u6d4b\u8bd5\u673a\u6784"}]}',
					),
					array(
						'test_url'=>C('API_URL').'Index/authentification',
						'update_time'=>'20161123',
						'name'=>'3、认证',
						'url'=>'Index/authentification',
						'type'=>'POST',
						'params'=>array(
							'name'=>'真实姓名',
							'mobile'=>' 手机号码',
							'code'=>'短信验证码',
							'ag_ids'=>'机构id  用“，”隔开',
							'openid'=>'微信openid',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败',
							'msg'=>'返回状态信息',
						),
						'back_eg'=>'{"status":0,"msg":"\u8bf7\u5728\u5fae\u4fe1\u7aef\u64cd\u4f5c\uff01"}',
					),
					array(
						'test_url'=>C('API_URL').'/Index/',
						'update_time'=>'20161123',
						'name'=>'4、首页',
						'url'=>'Index',
						'type'=>'POST',
						'params'=>array(
							'openid'=>'微信openid',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败 -1 未认证',
							'msg'=>'返回状态信息',
							'avatar'=>'用户微信头像',
							'成功返回数据：'=>'',
							'now_date'=>'现在时间日期 ',
							'week'=>'星期',
							'now_time'=>'目前时间',
							'slider_lists 轮播图'=>array(
								'name'=>'名称',
								'desc'=>'描述',
								'img'=>'图片',
								'skip_content'=>'跳转url',
							),
							'nav_lists  导航'=>array(
								'同轮播图数据'=>'',
							),
						),
						'back_eg'=>'{"status":1,"now_date":"2016\u5e7411\u670823\u65e5","week":"\u661f\u671f\u4e09","now_time":"16:25","slider_lists":[{"name":"\u8f6e\u64ad\u56fe1","desc":"\u6d4b\u8bd5\u4e00\u4e0b","img":"\/Static\/data\/uploads\/material\/advert\/2016\/11\/23\/5835320f71f63669853896.jpeg","ext":"jpeg","skip_content":"http:\/\/www.baodi.com"}],"nav_lists":[]}',
					),
					array(
						'test_url'=>C('API_URL').'/Course/get_course_lists',
						'update_time'=>'20161129',
						'name'=>'5、获取课表',
						'url'=>'Course/get_course_lists',
						'type'=>'POST',
						'params'=>array(
							'openid'=>'微信openid',
							'ag_id'=>'机构id',
							'teacher_id'=>'老师id',
							'student_id'=>'学生id',
							'select_time'=>'时间  2016-01-01',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败 -1 未认证',
							'msg'=>'返回状态信息',
							'time_line'=>'时间轴',
							'select_time'=>'日期时间',
							'course_lists 课表信息'=>array(
								'ag_id'=>'机构id',
								'teacher_id'=>'老师id',
								'course_id'=>'课程id',
								'teacher_name'=>'老师姓名',
								'agency_name'=>'机构名称',
								'course_name'=>'课程名称',
								'room_no'=>'教室名称',
								'detail'=>array(
									'student_id'=>'学生id',
									'student_name'=>'学生名字',
									'其他字段同上'
								),
							),
							'relate_data    机构其他信息'=>array(
								'id'=>'机构id',
								'ag_name'=>'机构名称',
								'teacher_lists'=>array(
									'同上'
								),
								'student_lists'=>array(
									'同上'
								),
							),
						),
						'back_eg'=>'{"status":1,"msg":"\u6570\u636e\u9519\u8bef\uff01","time_line":["10:00","10:55","11:50","12:45","13:40","14:35","15:30","16:25","17:20","18:15","19:10","20:05"],"select_time":["\u5468\u4e09  11\/30","\u5468\u56db  12\/01"],"course_lists":[[{"ag_id":"2","teacher_id":"3","course_id":"6","teacher_name":"\u6d4b\u8bd5\u8001\u5e08","agency_name":null,"course_name":"\u6162\u8dd1","room_no":"2-1","detail":[{"id":"2","ag_id":"2","ag_name":"\u6d4b\u8bd5\u673a\u6784","teacher_id":"3","teacher_name":"\u6d4b\u8bd5\u8001\u5e08","student_id":"8","student_name":"\u6d4b\u8bd5\u5b66\u751f2","course_id":"6","course_name":"\u6162\u8dd1","room_no":"2-1","period":"1","total_period":"15","start_time":"1480503667","end_time":"1480385500","open_time":null,"remark":null,"create_time":null,"sign_time":null,"is_adjust":"0","adjust_start_time":null,"adjust_end_time":null,"add_id":"0","status":"1"},{"id":"1","ag_id":"2","ag_name":"\u6d4b\u8bd5\u673a\u6784","teacher_id":"3","teacher_name":"\u6d4b\u8bd5\u8001\u5e08","student_id":"1","student_name":"\u6d4b\u8bd5\u5b66\u751f","course_id":"6","course_name":"\u6162\u8dd1","room_no":"2-1","period":"1","total_period":"15","start_time":"1480503667","end_time":"1480385500","open_time":null,"remark":null,"create_time":null,"sign_time":null,"is_adjust":"0","adjust_start_time":null,"adjust_end_time":null,"add_id":"0","status":"1"}]},[],[],[],[],[],[],[],[],[],[],[]],[[],[],[],[],[],[],[],[],[],[],[],[]]],"relate_data":[{"id":"2","name":"\u6d4b\u8bd5\u673a\u6784","teacher_lists":[{"id":"3","name":"\u6d4b\u8bd5\u8001\u5e08"}],"student_lists":[{"id":"1","name":"\u6d4b\u8bd5\u5b66\u751f"}]}]}',
					),
					array(
						'test_url'=>C('API_URL').'/Users/get_teacher_lists',
						'update_time'=>'20161130',
						'name'=>'6、获取机构下老师列表',
						'url'=>'Users/get_teacher_lists',
						'type'=>'POST',
						'params'=>array(
							'openid'=>'微信openid',
							'ag_id'=>'机构id',
						),
						'back'=>array(
							'status'=>'状态码 1 成功 0 失败',
							'msg'=>'状态吗对应信息',
							'lists  老师列表'=>array(
								'id'=>'老师id',
								'course_name'=>'课程名',
								'name'=>'老师名字',
								'mobile'=>'电话',
								'sex'=>'性别 0 未知  1 男 2 女',
							),
						),
						'back_eg'=>'{"status":0,"msg":"\u7cfb\u7edf\u9519\u8bef\uff01","lists":[{"id":"3","course_name":"\u67b6\u5b50\u9f13","name":"\u6d4b\u8bd5\u8001\u5e08","mobile":"15669023132","sex":"1"}]}',
					),
				),
			),
		),
	


	);
?>