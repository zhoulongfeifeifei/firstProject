<?php
namespace Api\Model;
use Think\Model;
class CourseModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取分类列表
	*/
	public function get_course_lists($condition=array(),$offset=0,$limit=20,$order='id DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	/**
	*添加分类
	*/

	public function add_course($data=array()){
		return $this->add($data);
	}

	/**
	*获取分类总数
	*/

	public function get_course_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取分类信息
	*/
	public function get_course_info($condition=array()){
		return $this->where($condition)->find();
	}
		/**
	*修改
	*/
	public function update_course($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_course($condition=array()){
		return $this->where($condition)->delete();
	}

	public function get_course_byfid($id=0){
		return $this->where("fid=$id")->select();
	}
}
?>