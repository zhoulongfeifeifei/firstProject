<?php
namespace Admin\Model;
use Think\Model;
class DepartmentModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取部门信息
	*/
	public function get_department_info($condition=array()){
		return $this->where($condition)->find();
	}

	/**
	*获取分类列表
	*/
	public function get_department_lists($condition=array(),$offset=0,$limit=20,$order='id DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	/**
	*添加部门
	*/

	public function add_department($data=array()){
		return $this->add($data);
	}

	/**
	*获取部门总数
	*/

	public function get_department_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}


		/**
	*修改
	*/
	public function update_department($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_department($condition=array()){
		return $this->where($condition)->delete();
	}

}
?>