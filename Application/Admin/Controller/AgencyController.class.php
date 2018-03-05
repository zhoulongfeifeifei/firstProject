<?php
namespace Admin\Controller;
use Think\Controller;
class AgencyController extends BaseController {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* 机构列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('agency_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$condition['name'] = array('like','%'.$name.'%');
	
		$AgencyModel = D('agency');
		$total_rows = $AgencyModel->get_agency_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $AgencyModel->get_agency_lists($condition,$offset,$numPerPage,$order);
		if(!empty($lists)){
			$UsersModel = D('users');
			foreach($lists as &$value){
				$info = $UsersModel->get_users_info(array('id'=>$value['boss']));
				$value['boss_name'] = $info['name'];
			}
		}

		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加机构
	*/
	public function add_agency(){
		//检查权限
		if(!checkPermission('add_agency')){
			return ;
		}
		
		if($_POST){
			$name = I('post.name','','trim');
			$ag_id = I('post.ag_id',0,'intval');
			$boss = I('post.boss',0,'intval');
			$reception = I('post.reception',0,'intval');
			$start_time = I('post.start_time','','trim');
			$end_time = I('post.end_time','','trim');
			$status = I('post.status',0,'intval');

			if(!$name){
				$error = '请输入机构名称！';
			}
			if(!$start_time){
				$error = '请选择开课时间！';
			}
			if(!$end_time){
				$error = '请选择结课时间！';
			}

			
			$AgencyModel = D('agency');
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$today = strtotime(date('Y-m-d 00:00:00',time()));
				$data = array(
					'ag_id'=>$ag_id,
					'boss'=>$boss,
					'reception'=>$reception,
					'name'=>$name,
					'start_time'=>strtotime($start_time)-$today,
					'end_time'=>strtotime($end_time)-$today,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$ag_id = $AgencyModel->add_agency($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					//关联人员信息
					$this->relate_agency_users($ag_id,$reception);
					$this->relate_agency_users($ag_id,$boss);

					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$UsersModel = D('users');
			$boss_lists = $UsersModel->get_users_lists(array('type'=>4,'status'=>1));

			$recep_lists = $UsersModel->get_users_lists(array('type'=>2,'status'=>1));

			$this->assign('recep_lists',$recep_lists);
			$this->assign('boss_lists',$boss_lists);
			$this->display();
		}
	}

	/**
	*修改机构
	*/
	public function edit_agency(){
		//检查权限
		if(!checkPermission('edit_agency')){
			return ;
		}
		$id = I('get.id',0,'intval');
		$AgencyModel = D('agency');
		//获取分类信息
		$info = $AgencyModel->get_agency_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$ag_id = I('post.ag_id',0,'intval');
			$boss = I('post.boss',0,'intval');
			$reception = I('post.reception',0,'intval');
			$start_time = I('post.start_time','','trim');
			$end_time = I('post.end_time','','trim');
			$status = I('post.status',0,'intval');

			if(!$name){
				$error = '请输入机构名称！';
			}
			if(!$start_time){
				$error = '请选择开课时间！';
			}
			if(!$end_time){
				$error = '请选择结课时间！';
			}

			
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$today = strtotime(date('Y-m-d 00:00:00',time()));
				$data = array(
					'ag_id'=>$ag_id,
					'boss'=>$boss,
					'reception'=>$reception,
					'name'=>$name,
					'start_time'=>strtotime($start_time)-$today,
					'end_time'=>strtotime($end_time)-$today,
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = "id=$id";
				if(!$AgencyModel->update_agency($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					//关联人员信息
					$this->relate_agency_users($id,$reception,$info['reception']);
					$this->relate_agency_users($id,$boss,$info['boss']);

					$r['statusCode'] = 200;
					$r['message'] = '修改成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$UsersModel = D('users');
			$boss_lists = $UsersModel->get_users_lists(array('type'=>4,'status'=>1));
			$this->assign('boss_lists',$boss_lists);
			$recep_lists = $UsersModel->get_users_lists(array('type'=>2,'status'=>1));

			$this->assign('recep_lists',$recep_lists);
			$this->assign('info',$info);

			$this->display();
		}
	}

	/**
	*删除机构
	*/
	public function del_agency(){
		//检查权限
		if(!checkPermission('del_agency')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = "id=$id";
		
		$AgencyModel = D('agency');
		$AgencyCourseModel = D('agencyCourse');

		$ckagency = $AgencyCourseModel->get_agency_course_info(array('ag_id'=>$id));
		if($ckagency){
			$error = '此机构下存在课程安排不能删除！';
		}
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$AgencyModel->delete_agency($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'agency_lists';
		}
		die(json_encode($r));
	}

	/**
	*添加机构关联用户
	* @param $ag_id 机构id
	* @param $user_id 用户id
	* @param $src_id  原用户id
	*/
	public function relate_agency_users($ag_id,$user_id,$src_id){
		if($ag_id && $user_id){
			$UsersModel = D('users');
			$user_info = $UsersModel->get_users_info(array('id'=>$user_id));
			$insertData = array(
				'ag_id'=>$ag_id,
				'user_id'=>$user_info['id'],
				'name'=>$user_info['name'],
				'user_type'=>$user_info['type'],
				'mobile'=>$user_info['mobile'],
				'create_time'=>time(),
				'status'=>1
			);
			$AgencyUsersModel = D('agencyUsers');
			$AgencyUsersModel->add_agency_users($insertData);
		}
		if($src_id>0){
			$AgencyUsersModel = D('agencyUsers');
			$AgencyUsersModel->delete_agency_users(array('ag_id'=>$ag_id,'user_id'=>$src_id));
		}
	}

	//机构课程列表
	public function agency_course_lists(){
		//检查权限
		if(!checkPermission('agency_course_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$ag_id = I('get.ag_id',0,'intval');
		if(!$name){
			$condition['name'] = array('like','%'.$name.'%');
		}

		$condition['ag_id'] = $ag_id;
	
		$AgencyCourseModel = D('agencyCourse');
		$total_rows = $AgencyCourseModel->get_agency_course_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $AgencyCourseModel->get_agency_course_lists($condition,$offset,$numPerPage,$order);

		$CourseModel = D('course');

		foreach($lists as &$val){
			$course = $CourseModel->get_course_info(array('id'=>$val['course_id']));
			$val['course_name'] = $course['name'];
		}

		$this->assign('result',$lists);

		$this->display();
	}

		/**
	*添加机构课程
	*/
	public function add_agency_course(){
		//检查权限
		if(!checkPermission('add_agency_course')){
			return ;
		}

		$ag_id = I('get.ag_id',0,'intval');
		$AgencyModel = D('agency');
		$agency = $AgencyModel->get_agency_info(array('id'=>$ag_id));

		if($_POST){
			$course_id = I('post.course_id',0,'intval');
			$course_time = I('post.course_time',0,'intval');
			$rest_time = I('post.rest_time',0,'intval');
			$classroom = I('post.classroom',1,'intval');
			$nums = I('post.nums',1,'intval');
			$status = I('post.status',0,'intval');

			if(!$course_id){
				$error = '请选择课程！';
			}
			if(!$course_time){
				$error = '请输入课程时长！';
			}
			if(!$rest_time){
				$error = '请输入间隔休息时间！';
			}

			$AgencyCourseModel = D('agencyCourse');
			$ckres = $AgencyCourseModel->get_agency_course_info(array('ag_id'=>$ag_id,'course_id'=>$course_id));

			if($ckres){
				$error = '该课程已经添加！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'ag_id'=>$ag_id,
					'course_id'=>$course_id,
					'course_time'=>$course_time,
					'rest_time'=>$rest_time,
					'classroom'=>$classroom,
					'nums'=>$nums,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$AgencyCourseModel->add_agency_course($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_course_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			
			$CourseModel = D('course');
			$course_lists = $CourseModel->get_course_lists(array('status'=>1));
			$course_lists = getCategoryLists($course_lists);
			$this->assign('course_lists',$course_lists);
			$this->assign('agency',$agency);

			$this->display();
		}
	}

	//修改机构课程
	public function edit_agency_course(){
		//检查权限
		if(!checkPermission('edit_agency_course')){
			return ;
		}
		$id = I('get.id',0,'intval');
		$ag_id = I('get.ag_id',0,'intval');
		$AgencyCourseModel = D('agencyCourse');
		//获取分类信息
		$info = $AgencyCourseModel->get_agency_course_info(array('id'=>$id));
		if($_POST){
			$course_id = I('post.course_id',0,'intval');
			$course_time = I('post.course_time',0,'intval');
			$rest_time = I('post.rest_time',0,'intval');
			$classroom = I('post.classroom',1,'intval');
			$nums = I('post.onetoone',1,'intval');
			$status = I('post.status',nums,'intval');

			if(!$course_id){
				$error = '请选择课程！';
			}
			if(!$course_time){
				$error = '请输入课程时长！';
			}
			if(!$rest_time){
				$error = '请输入间隔休息时间！';
			}

			$AgencyCourseModel = D('agencyCourse');
			$condition = array('ag_id'=>$ag_id,'course_id'=>$course_id,'id'=>array('neq',$id));
			$ckres = $AgencyCourseModel->get_agency_course_info($condition);

			if($ckres){
				$error = '该课程已经添加！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'course_id'=>$course_id,
					'course_time'=>$course_time,
					'rest_time'=>$rest_time,
					'classroom'=>$classroom,
					'nums'=>$nums,
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = "id=$id";
				if(!$AgencyCourseModel->update_agency_course($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '修改成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_course_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$CourseModel = D('course');
			$course_lists = $CourseModel->get_course_lists(array('status'=>1));
			$course_lists = getCategoryLists($course_lists);
			$this->assign('course_lists',$course_lists);
			$this->assign('info',$info);

			$this->display();
		}
	}

	//删除机构课程
	public function del_agency_course(){
		//检查权限
		if(!checkPermission('del_agency_course')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = "id=$id";
		
		$AgencyCourseModel = D('agencyCourse');
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$AgencyCourseModel->delete_agency_course($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'agency_course_lists';
		}
		die(json_encode($r));
	}

	//机构用户列表
	public function agency_users_lists(){
		//检查权限
		if(!checkPermission('agency_users_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$ag_id = I('get.ag_id',0,'intval');
		$type = I('post.type',0,'intval');
		if($name || $type>0){
			$UsersModel = D('users');
			$where = array();
			$where['name'] = array('like','%'.$name.'%');
			$where['type'] = $type;
			$users = $UsersModel->get_users_lists($where);
			$ids = array();
			foreach($users as $v){
				$ids[]= $v['id'];
			}
			$idsStr = implode(',', $ids);
			$condition['user_id'] = array('in',$idsStr);
		}

		$condition['ag_id'] = $ag_id;
	
		$AgencyUsersModel = D('agencyUsers');
		$total_rows = $AgencyUsersModel->get_agency_users_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $AgencyUsersModel->get_agency_users_lists($condition,$offset,$numPerPage,$order);
		
		$UsersModel = D('users');
		$AgencyModel = D('agency');
		foreach($lists as &$value){
			$users_info = $UsersModel->get_users_info(array('id'=>$value['user_id']));
			$value['user_name'] = $users_info['name'];
			$value['user_type'] = $users_info['type'];
			//获取机构
			$agency = $AgencyModel ->get_agency_info(array('id'=>$value['ag_id']));
			$value['agency_name'] = $agency['name'];
		}
		$this->assign('result',$lists);
		$this->display();
	}


	/**
	*添加机构用户
	*/
	public function add_agency_users(){
		//检查权限
		if(!checkPermission('add_agency_users')){
			return ;
		}

		$ag_id = I('get.ag_id',0,'intval');
		$AgencyModel = D('agency');
		$agency = $AgencyModel->get_agency_info(array('id'=>$ag_id));

		if($_POST){
			$user_id = I('post.user_id',0,'intval');
			$mobile = I('post.mobile','','trim');
			$tel_phone = I('post.tel_phone','','trim');
			$remark = I('post.remark','','trim');
			$status = I('post.status',0,'intval');

			if(!$user_id){
				$error=  '请选择用户';
			}

			if(!$mobile && !$tel_phone){
				$error = '请输入一个预留电话';
			}
			$UsersModel = D('users');
			$user_info = $UsersModel->get_users_info(array('id'=>$user_id));
			if(empty($user_info)){
				$error = '用户不存在';
			}

			$AgencyUsersModel = D('agencyUsers');
			$ckres = $AgencyUsersModel->get_agency_users_info(array('ag_id'=>$ag_id,'user_id'=>$user_id));

			if($ckres){
				$error = '该用户已经添加！';
			}

			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'ag_id'=>$ag_id,
					'user_id'=>$user_id,
					'name'=>$user_info['name'],
					'mobile'=>$mobile,
					'tel_phone'=>$tel_phone,
					'remark'=>$remark,
					'user_type'=>$user_info['type'],
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$AgencyUsersModel->add_agency_users($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_users_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->assign('agency',$agency);
			$this->display();
		}
	}

	/**
	*修改机构用户
	*/
	public function edit_agency_users(){
		//检查权限
		if(!checkPermission('add_agency_users')){
			return ;
		}
		$UsersModel = D('users');
		$ag_id = I('get.ag_id',0,'intval');
		$id = I('get.id',0,'intval');
		$AgencyModel = D('agency');
		$agency = $AgencyModel->get_agency_info(array('id'=>$ag_id));

		$AgencyUsersModel = D('agencyUsers');
		$info = $AgencyUsersModel->get_agency_users_info(array('id'=>$id));
		if($_POST){
			$user_id = I('post.user_id',0,'intval');
			$mobile = I('post.mobile','','trim');
			$tel_phone = I('post.tel_phone','','trim');
			$remark = I('post.remark','','trim');
			$status = I('post.status',0,'intval');

			if(!$user_id){
				$error=  '请选择用户';
			}

			if(!$mobile && !$tel_phone){
				$error = '请输入一个预留电话';
			}

			$user_info = $UsersModel->get_users_info(array('id'=>$user_id));
			if(empty($user_info)){
				$error = '用户不存在';
			}

			$condition = array(
				'ag_id'=>$ag_id,
				'user_id'=>$user_id,
				'id'=>array('neq',$id),
			);
			$ckres = $AgencyUsersModel->get_agency_users_info($condition);

			if($ckres){
				$error = '该用户已经添加！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'ag_id'=>$ag_id,
					'user_id'=>$user_id,
					'name'=>$user_info['name'],
					'mobile'=>$mobile,
					'tel_phone'=>$tel_phone,
					'remark'=>$remark,
					'user_type'=>$user_info['type'],
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = array('id'=>$id);
				if(!$AgencyUsersModel->update_agency_users($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '修改成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'agency_users_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->assign('agency',$agency);
			
			$user_info = $UsersModel->get_users_info(array('id'=>$info['user_id']));
			$info['user_name'] = !empty($user_info) ? $user_info['name'] : '';
			$this->assign('info',$info);
			$this->display();
		}
	}



	//删除机构课程
	public function del_agency_users(){
		//检查权限
		if(!checkPermission('del_agency_users')){
			return ;
		}
		$id= I('get.id',0,'trim');
		$condition = "id=$id";
		
		$AgencyUsersModel = D('agencyUsers');
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$AgencyUsersModel->delete_agency_Users($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'agency_users_lists';
		}
		die(json_encode($r));
	}

	//搜索用户列表
	public function get_users_lists(){
		$name = I('post.name','','trim');
		$type = I('post.type',0,'intval');
		$UsersModel = D('users');
		$condition = array('status'=>1);
		if($type>0){
			$condition['type'] = $type;
		}
		$condition['name'] = array('like','%'.$name.'%');
		$lists = $UsersModel->get_users_lists($condition);
		die(json_encode(array('lists'=>$lists)));
	}

	//获取机构列表
	public function search_agency_lists(){
		$name = I('post.name','','trim');
		$AgencyModel = D('agency');
		$condition = array('status'=>1);
		$condition['name'] = array('like','%'.$name.'%');
		$lists = $AgencyModel->get_agency_lists($condition);
		die(json_encode(array('lists'=>$lists)));
	}

}