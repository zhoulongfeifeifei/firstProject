<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends BaseController {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* 分类列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('users_lists')){
			return ;
		}
		$condition = array();
		$ids = array();

		$UsersModel = D('Users');
		$name = I('post.name','','trim');
		$type = I('post.type','','intval');
		
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}
		
		if($type>0){
			$condition['type'] = $type;
		}

		$total_rows = $UsersModel->get_users_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$order = 'id DESC';
		$lists = $UsersModel->get_users_lists($condition,$offset,$numPerPage,$order);
		
		$this->assign('result',$lists);

		$this->display();
	}

	/**
	*添加用户
	*/
	public function add_users(){
		//add_subject
		if(!checkPermission('add_users')){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
			$mobile = I('post.mobile','','trim');
			$sex = I('post.status',0,'intval');
			$status = I('post.status',0,'intval');
			$type = I('post.type',0,'intval');
			if(!$name){
				$error = '请输入名称！';
			}
			if(!$mobile){
				$error = '请输入电话！';
			}
			if(!$type){
				$error = '请选择用户类型！';
			}
			if(!$sex){
				$error = '请选择性别！';
			}
			$where = array(
				'name'=>$name,
			);
			$UsersModel = D('Users');
			$ckname = $UsersModel->get_users_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'mobile'=>$mobile,
					'sex' => $sex,
					'type'=>$type,
					'create_time'=>time(),
					'status'=>$status,
				);
				if(!$UsersModel->add_users($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'users_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->display();
		}
	}

	/**
	* 修改用户信息
	*/
	public function edit_users(){
		//检查权限
		if(!checkPermission('edit_users')){
			return ;
		}
		$id = I('get.id',0,'intval');
		$UsersModel = D('Users');
		//获取分类信息
		$info = $UsersModel->get_users_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$mobile = I('post.mobile','','trim');
			$sex = I('post.status',0,'intval');
			$status = I('post.status',0,'intval');
			$type = I('post.type',0,'intval');
			if(!$name){
				$error = '请输入名称！';
			}
			if(!$mobile){
				$error = '请输入电话！';
			}
			if(!$sex){
				$error = '请选择性别！';
			}
			$where = array(
				'id'=>array('neq',$id),
				'name'=>$name,
			);
			$ckname = $UsersModel->get_users_info($where);
			if($ckanem){
				$error = '此学科已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data = array(
					'name'=>$name,
					'mobile'=>$mobile,
					'sex' => $sex,
					'type'=>$type,
					'update_time'=>time(),
					'status'=>$status,
				);
				$where = "id=$id";
				if(!$UsersModel->update_users($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'users_lists';
				}
				
			}
			die(json_encode($r));
		}else{
			
			$this->assign('info',$info);
			$this->display();
		}
	}

	/**
	*删除
	*/
	public function del_users(){
		//检查权限
		if(!checkPermission('del_users')){
			return ;
		}
		$UsersModel = D('Users');
		$id= I('get.id',0,'intval');
		$condition = array('id'=>$id);
		$info = $UsersModel->get_users_info(array('id'=>$id));

		if(!$info){
			$error = '数据错误！';
		}
		if($info['type']==2){
			$error='老板不能删除';
		}

		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;
		}else if(!$UsersModel->delete_users($condition)){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'users_lists';
		}
		die(json_encode($r));
	}


	/**
	*获取用户列表
	*/
	public function get_agency_users_lists(){
		$ag_id = I('post.ag_id',0,'intval');
		$type = I('post.type',0,'intval');
		$name = I('post.name','','trim');
		$lists = array();
		if($ag_id){
			$AgencyUsersModel = D('agencyUsers');
			$condition = array('ag_id'=>$ag_id,'status'=>1);
			if($name){
				$condition['name'] = array('like','%'.$name.'%');
			}
			$agency_users_lists = $AgencyUsersModel->get_agency_users_lists($condition);
			$UsersModel = D('users');
			$CourseModel = D('course');
			foreach($agency_users_lists as $v){
				$user_info = $UsersModel->get_users_info(array('id'=>$v['user_id']));
				if($user_info['type']==$type){
					if($v['course_id']>0){
						$course = $CourseModel->get_course_info(array('id'=>$v['course_id']));
						$user_info['course_name'] = $course['name'];
					}

					$lists[]=$user_info;
				}
			}
		}
		die(json_encode(array('lists'=>$lists)));
	}

}