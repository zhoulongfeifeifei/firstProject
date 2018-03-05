<?php
namespace Admin\Model;
use Think\Model;
class ItemsModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取列表
	*/
	public function get_items_lists($condition=array(),$offset=0,$limit=20,$order='id DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	/**
	*添加
	*/

	public function add_items($data=array()){
		return $this->add($data);
	}

	/**
	*获取总数
	*/

	public function get_items_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取信息
	*/
	public function get_items_info($condition=array()){
		return $this->where($condition)->find();
	}
		/**
	*修改
	*/
	public function update_Items($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_Items($condition=array()){
		return $this->where($condition)->delete();
	}

}
?>