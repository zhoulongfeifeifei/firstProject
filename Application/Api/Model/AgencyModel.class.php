<?php
namespace Api\Model;
use Think\Model;
class AgencyModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取分类列表
	*/
	public function get_agency_lists($condition=array(),$field='*',$offset=0,$limit=20,$order='ag_id DESC'){
		return $this->field($field)->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	/**
	*添加分类
	*/

	public function add_agency($data=array()){
		return $this->add($data);
	}

	/**
	*获取分类总数
	*/

	public function get_agency_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取分类信息
	*/
	public function get_agency_info($condition=array()){
		return $this->where($condition)->find();
	}
		/**
	*修改
	*/
	public function update_agency($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_agency($condition=array()){
		return $this->where($condition)->delete();
	}

	public function get_agency_byfid($id=0){
		return $this->where("fid=$id")->select();
	}
}
?>