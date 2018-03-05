<?php
namespace Admin\Controller;
use Think\Controller;
class SystemController extends BaseController {

	protected $EmployeeModel;
	protected $DepartmentModel;
	protected $ids;//下级人员id

	public function __construct(){
		parent::__construct();
		$this->EmployeeModel = D('Employee');
		$this->DepartmentModel = D('Department');
	}

/***********************************************************人员管理***********************************************************************/
	/**
	* 系统人员列表
	*/
	public function employee(){
		//检查权限
		if(!checkMenuPermission('employee')){
			return ;
		}
		$condition = array();
		$name = I('post.name','','trim');
		$condition['name'] = array('like','%'.$name.'%');
		if(session('is_director') ==0){//普通人员  获取下级
			$this->ids = array();
			$info[] = $this->EmployeeModel->get_employee_info(array('id'=>session('employee_id')));
			$ids = $this->get_child_byinfo($info);
			foreach($ids as $k=>$id){
				if($id==session('employee_id')){
					unset($ids[$k]);
					break;
				}
			}
			$condition['id'] = array('in',implode(',', $ids));
		}else if(session('is_director')==2){//部门主管 直接获取部门下人员
			$condition['did'] = session('employee_did');
			$condition['id'] = array('neq',session('employee_id'));
		}
		
		//获取总数
		$total_rows = $this->EmployeeModel->get_employee_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$result = $this->EmployeeModel->get_employee_lists($condition,$offset,$limit);
		foreach($result as &$item){
			$department = $this->DepartmentModel->get_department_info(array('id'=>$item['did']));
			$item['d_name'] = $department['name'];
		}
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$result);
		$this->display();
	}	

	/**
	* 递归获取下级人员信息
	* @param $info 人员信息
	*/
	protected function get_child_byinfo($info = array()){
		foreach($info as $value){
			$data = $this->EmployeeModel->get_childid_byfid($value['id']);
			$this->ids[]=$value['id'];
			if(!empty($data)){
				return $this->get_child_byinfo($data);
			}
		}
		return $this->ids;
	}

	/**
	* 添加人员  
	*/

	public function add_employee(){
		//检查权限
		if(!checkPermission('add_employee')){
			return ;
		}
		if($_POST){
			$did = I('post.did',0,'intval');
			$account = I('post.account','','trim');
			$passwd = I('post.passwd','','trim');
			$name = I('post.name','','trim');
			$fid = I('post.fid',0,'intval');
			$is_director = I('post.is_director',0,'intval');
			$error = '';
			$data = array();
			if(!$fid && !$is_director){
				$error = '请选择上级人员!';
			}
			if($did ==0){
				$error = '请选择部门！';
			}else if($account && $passwd && $name){
				$ckemployee = $this->EmployeeModel->get_employee_lists("`account`='$account' OR `name`='$name'");
				if($ckemployee){
					$error = '帐号或者姓名已经存在！';
				}else{
					$data['did'] = $did;
					$data['account'] = $account;
					$data['password'] = md5($passwd);
					$data['is_director'] = $is_director;
					$data['name'] = $name;
					$data['create_time'] = time();;
					$data['fid'] = $fid;
				}
			}else{
				$error='请输入内容！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				if(!$this->EmployeeModel->add_employee($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'employee';
				}
				
			}
			die(json_encode($r));

		}else{
			if(session('is_director')==1){
				$department = $this->DepartmentModel->get_department_lists('1=1');
			}else{
				$department = $this->DepartmentModel->get_department_lists(array('id'=>session('employee_did')));
			}
			$this->assign('department',$department);
			$this->display();
		}
	}

	/**
	*获取部门下人员列表
	*/

	public function get_employee_bydid(){
		$did = I('post.did',0,'intval');
		$condition = '';
		$ids = array();
		if(session('is_director')==1){
			$condition['did'] = $did;
		}else if(session('is_director')==2){
			$condition['did'] = session('employee_did');
			$condition['id'] = array('neq',session('employee_id'));
		}else{
			$condition['did'] = session('employee_did');
			$this->ids = array();
			$info[] = $this->EmployeeModel->get_employee_info(array('id'=>session('employee_id')));
			$ids = $this->get_child_byinfo($info);
			foreach($ids as $k=>$id){
				if($id==session('employee_id')){
					unset($ids[$k]);
					break;
				}
			}
			$condition['id'] = array('in',implode(',', $ids));
		}
		$result = $this->EmployeeModel->get_employee_lists($condition);
		$code = session('is_director')==1 ? 0 : session('employee_id');
		$result = getEmployeeLists($result,$code);
		$callbackfunc = I('param.callback','','trim');
		if($callbackfunc){
			die($callbackfunc.'('.json_encode($result).')');
		}else{
			 die(json_encode($result));
		}
	}

	/**
	*修改人员信息
	*/

	public function edit_employee(){
		//检查权限
		if(!checkPermission('edit_employee')){
			return ;
		}
		$employee_id = I('get.id',0,'intval');
		if($_POST){
			$did = I('post.did',0,'intval');
			$fid = I('post.fid',0,'intval');
			$is_director = I('post.is_director',0,'intval');
			$passwd = I('post.passwd','','trim');
			if(!$fid && !$is_director){
				$error = '请选择上级人员!';
			}
			if(!$did){
				$error = '请选择部门';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$where['id']=$employee_id;
				$data = array(
					'did'=>$did,
					'fid'=>$fid,
					'is_director'=>$is_director,
					'update_time'=>time(),
				);
				if($passwd){
					$data['password'] = md5($passwd);
				}
				if(!$this->EmployeeModel->update_employee($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '修改成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'employee';
				}
				
			}
			die(json_encode($r));
		}else{
			$this->assign('employee_id',$employee_id);
			$info = $this->EmployeeModel->get_employee_info(array('id'=>$employee_id));
			$this->assign('info',$info);
			
			$condition = array();
			if(session('is_director')!=1){
				$this->ids = array(session('employee_id'));
				$ids = array();
				$info = $this->EmployeeModel->get_childid_byfid(session('employee_id'));
				$ids = $this->get_child_byinfo($info);
				foreach($ids as $k=>$id){
					if($id==$employee_id){
						unset($ids[$k]);
					}
				}
				$condition['id'] = array('in',implode(',', $ids));
			}else{
				$condition['id'] = array('neq',$employee_id);
			}
			$department = array();
			if(session('is_director')!=1){
				$condition['did'] = session('employee_did');
				$department[] = $this->DepartmentModel->get_department_info(array('id'=>session('employee_did')));
			}else{
				$department = $this->DepartmentModel->get_department_lists();
			}
			$this->assign('department',$department);
			$employee = $this->EmployeeModel->get_employee_lists($condition);
			$res = getEmployeeLists($employee,session('employee_info')['fid']);
			$this->assign('employee',$res);
			$this->display();
		}
	}

	/**
	*删除人员
	*/

	public function del_employee(){
		//检查权限
		if(!checkPermission('del_employee')){
			return ;
		}
		$employee_id = I('get.id',0,'intval');
		if(!$this->EmployeeModel->delete_employee(array('id'=>$employee_id))){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'employee';
		}
		die(json_encode($r));
	}

/***********************************************************部门管理***********************************************************************/

	/**
	*获取部门列表
	*/
	public function department(){
		//检查权限
		if(!checkMenuPermission('department')){
			return ;
		}
		$condition = array();
		$ids = array();

		$name = I('post.name','','trim');
		$condition['name'] = array('like','%'.$name.'%');
		$total_rows = $this->DepartmentModel->get_department_count($condition);

		$numPerPage = I('post.numPerPage',C('PER_PAGE'),'intval');
		$pageNum = I('post.pageNum',1,'intval');
		$offset = ($pageNum - 1 ) * $numPerPage;

		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$numPerPage);
		$this->assign('current_page',$pageNum);
		$lists = $this->DepartmentModel->get_department_lists($condition,$offset,$numPerPage);
		$this->assign('result',$lists);
		$this->display();
	}

	/**
	* 添加部门
	*/
	public function add_department(){
		//检查权限
		if(!checkPermission('add_department')){
			return ;
		}
		if($_POST){
			$name = I('post.name','','trim');
			$permission = I('post.permission','','trim');
			$error = '';
			if(!$name){
				$error = '请输入部门名！';
			}
			$info = $this->DepartmentModel->get_department_info(array('name'=>$name));
			if($info){
				$error = '此部门已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['name'] = $name;
				$data['create_time'] = time();
				$data['permission'] = implode(',', $permission);
				if(!$this->DepartmentModel->add_department($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'department';
				}
				
			}
			die(json_encode($r));

		}else{
			$this->display();
		}
	}

	/**
	* 添加部门
	*/
	public function edit_department(){
		//检查权限
		if(!checkPermission('edit_department')){
			return ;
		}
		$did = I('get.did',0,'trim');
		$info = $this->DepartmentModel->get_department_info(array('id'=>$did));
		if($_POST){
			$name = I('post.name','','trim');
			$permission = I('post.permission','','trim');
			$error = '';
			if(!$name){
				$error = '请输入部门名！';
			}
			if($info && $info['id']!=$did){
				$error = '此部门已经存在！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['name'] = $name;
				$data['update_time'] = time();
				$data['permission'] = implode(',', $permission);
				$condition = "id=$did";
				if(!$this->DepartmentModel->update_department($condition,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'department';
				}
				
			}
			die(json_encode($r));

		}else{
			$info['permission'] = explode(',', $info['permission']);
			$this->assign('info',$info);
			$this->display();
		}
	}
	/**
	*删除部门
	*/

	public function del_department(){
		//检查权限
		if(!checkPermission('del_department')){
			return ;
		}
		$department_id = I('get.did',0,'intval');
		$ckemployee = $this->EmployeeModel->get_employee_info(array('did'=>$department_id));
		if($ckemployee){
			$error = '此部门下存在人员信息，不能删除！';
		}
		if(!empty($error)) {
			$r['statusCode'] = 300;
			$r['message'] = $error;	
		} else if(!$this->DepartmentModel->delete_department("id=$department_id")){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'department';
		}
		die(json_encode($r));
	}

	/**
	*添加权限
	*
	*/
	public function add_permission(){
		//检查权限
		if(!checkPermission('add_employee_permission')){
			return ;
		}
		$employee_id = I('get.id',0,'intval');
		if($_POST){
			$error = '';
			if($employee_id<=0){
				$error = '参数错误请稍后再试！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data =array('permission'=>implode(',',I('post.permission','','trim')));
				$where = array('id'=>$employee_id);
				if(!$this->EmployeeModel->update_employee($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'employee';
				}
				
			}
			die(json_encode($r));
		}else{
			$info = $this->EmployeeModel->get_employee_info(array('id'=>$employee_id));
			//获取所在部门权限
			$department = $this->DepartmentModel->get_department_info(array('id'=>$info['did']));
			$department_permission = !empty($department['permission']) ? explode(',', $department['permission']) : array();
			$this->assign('department_permission',$department_permission);

			//获取原始用户权限
			$permission = !empty($info['permission']) ? explode(',', $info['permission']) : array();
			$this->assign('src_permission',$permission);
			$this->assign('employee_id',$employee_id);
			$this->display();
		}
	}

}