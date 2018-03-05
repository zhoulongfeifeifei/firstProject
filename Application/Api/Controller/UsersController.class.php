<?php
namespace Api\Controller;
use Think\Controller;
class UsersController extends BaseController {

	public function __construct(){
		parent::__construct();	
	}

	public function index(){

	}

	/**
	*老师列表
	*/
	public function get_teacher_lists(){
		$arr = array(2,4);
		$ag_id = I('post.ag_id',0,'intval');
		$keywords = I('post.keywords','','trim');
		$result = array('status'=>0,'msg'=>'系统错误！');
		//检查认证
		$user_info = $this->check_authentification();

		if(!in_array($user_info['type'],$arr)){
			$result['msg'] = '无权限操作！';
		}else{
			$AgencyUsersModel = D('agencyUsers');
			$UsersModel = D('users');
			$where = array(
				'ag_id'=>$ag_id,
				'user_type'=>3,
				'status'=>1
			);
			if($keywords){
				$where['name'] = array('like','%'.$keywords.'%');
			}
			$lists = $AgencyUsersModel->get_agency_users_lists($where);
			$res = array();
			foreach($lists as $value){
				$info = $UsersModel->get_users_info(array('id'=>$value['user_id']));

				$res[] = array(
					'id'=>$value['user_id'],
					'course_name'=>$value['course_name'],
					'name'=>$info['name'],
					'mobile'=>$value['mobile'] ? $value['mobile'] : $value['tel_phone'],
					'sex'=>$info['sex'],
				);
			}
			$result['status'] = 1;
			$result['lists'] = $res;
		}

		die(json_encode($result));
	}


	/**
	*添加老师
	*/

	public function add_teacher(){
		$arr = array(2,4);
		$ag_id = I('post.ag_id',0,'intval');
		$result = array('status'=>0,'msg'=>'系统错误！');
		//检查认证
		$user_info = $this->check_authentification();
		if(!in_array($user_info['type'],$arr)){
			$result['status'] =2;
			$result['msg'] = '无权限操作！';
		}else{
			$ag_id = I('post.ag_id',0,'intval');
			$name = I('post.name','','trim');
			$sex = I('post.sex',0,'intval');
			$mobile = I('post.mobile','','trim');
			$tel_phone = I('post.tel_phone','','trim');
			$course_id = I('post.course_id',0,'intval');
			$start_time = I('post.start_time',0,'trim');
			$error = '';
			$UsersModel = D('users');
			$AgencyUsersModel = D('agencyUsers');

			if(!$name || !$sex || !$mobile || !$ag_id || !$course_id ){
				$error = '请完善数据！';
			}else if($ag_id){
				//检查机构是否存在
				$AgencyModel = D('agency');
				$ckwhere = array(
					'id'=>$ag_id,
					'status'=>1
				);
				$ckres = $AgencyModel->get_agency_info($ckwhere);
				if(empty($ckres)){
					$error = '机构不存在！';
				}
			}else if($course_id){
				//价差课程
				$AgencyCourse = D('agencyCourse');
				$ckwhere = array(
					'ag_id'=>$ag_id,
					'course_id'=>$course_id,
					'status'=>1
				);
				$course = $AgencyCourse->get_agency_course_info($ckwhere);
				if(empty($course)){
					$error = '该机构下没有此课程！';
				}
			}else{
				//检查用户是否已经存在
				$ckwhere = array(
					'name'=>$name,
					'status'=>1,
				);
				$user = $UsersModel->get_users_info($ckwhere);

				if($user){
					//检查机构下是否存在
					$where = array(
						'ag_id'=>$ag_id,
						'user_id'=>$user['id'],
					);
					$agency_users = $AgencyUsersModel->get_agency_users_info($where);
					if(!empty($agency_users)){
						$error = '该老师已经存在，请勿重复添加！';
					}
				}
				
			}

			if(!$error){
				M()->startTrans();
				//用户基本信息不存在
				if(empty($user)){
					$data = array(
						'name'=>$name,
						'sex'=>$sex,
						'mobile'=>$mobile,
						'type'=>3,
						'create_time'=>time(),
						'status'=>1,
					);
					$user_id = $UsersModel->add_users($data);
				}else{
					$user_id = $user['id'];
				}
				if($user_id>0){
					$agencyUsersData = array(
						'ag_id'=>$ag_id,
						'user_id'=>$user_id,
						'mobile'=>$mobile,
						'tel_phone'=>$tel_phone,
						'user_type'=>3,
						'course_id'=>$course_id,
						'course_name'=>$course['name'],
						'create_time'=>time(),
						'start_time'=>strtotime($start_time),
					);
					if($AgencyUsersModel->add_agency_users($agencyUsersData)){
						$status = 1;
					}
				}
				if($status==1){
					M()->commit();
					$result['status'] =1;
					$error = '添加成功！';
				}else{
					M()->rollback();
				}				

			}
			$result['msg'] = $error;
		}
		die(json_encode($result));
	}


}
