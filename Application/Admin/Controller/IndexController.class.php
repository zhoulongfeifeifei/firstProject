<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

	public function index(){
		if(!session('employee_id')){
			exit('<script type="text/javascript">location.href="/admin/Index/login";</script>');
		}
		$this->display();
	}

	/**
	*登录
	*/
	public function login(){
		if($_POST){
			$account = I('post.account','','trim');
			$passwd = I('post.password','','trim');
			$msg = '';
			if(!$account || !$passwd){
				$msg = '请输入用户名密码！';
			}else{
				$condition = array(
					'account'=>$account,
					'password'=>md5($passwd),
				);
				$employee = D('Employee')->get_employee_info($condition);
				if($employee){
					$where = array('id'=>$employee['did']);
					$department = D('Department')->get_department_info($where);
					$arr = $employee['permission'].','.$department['permission'];
					$arr = explode(',', $arr);
					$permission = array();
					foreach($arr as $item){
						if(trim($item)){
							$permission[]=$item;
						}
					}
					session('employee_info',$employee);
					session('employee_id',$employee['id']);
					session('employee_permission',$permission);
					session('is_director',$employee['is_director']);
					session('employee_did',$employee['did']);
					$data['status'] =1;
					$data['success_url'] = '/admin/Index';
				}else{
					$msg = '帐号用户名错误，请重新输入！';
				}
			}
			$data['msg'] = $msg;
			die(json_encode($data));
		}else{
			$this->display();
		}
	}

	public function loginout(){
		session(null);
		exit('<script type="text/javascript">location.href="/admin/Index/login";</script>');
	}


}