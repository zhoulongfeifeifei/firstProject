<?php
namespace Admin\Model;
use Think\Model;
class EmployeeModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取人员信息
	*/
	public function get_employee_info($condition=array()){
		return $this->where($condition)->find();
	}

	/**
	*获取分类列表
	*/
	public function get_employee_lists($condition=array(),$offset=0,$limit=20,$order='id DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	/**
	*添加分类
	*/

	public function add_employee($data=array()){
		return $this->add($data);
	}

	/**
	*获取分类总数
	*/

	public function get_employee_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取下级人员
	*/
	public function get_childid_byfid($id=0){
		return $this->where("fid=$id")->select();
	}

	/**
	*修改
	*/
	public function update_employee($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}
	
	/**
	* 删除
	*/
	public function delete_employee($condition=array()){
		return $this->where($condition)->delete();
	}
}
?>