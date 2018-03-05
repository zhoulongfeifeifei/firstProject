<?php
namespace Admin\Model;
use Think\Model;
class WechatUsersModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取列表
	*/
	public function get_users_list($condition=array(),$offset=0,$limit=20,$order='no_read_msg DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}

	/**
	*获取总数
	*/

	public function get_users_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/*
	*获取信息
	*/
	public function get_users_info($condition=array()){
		return $this->where($condition)->find();
	}

	/**
	*修改
	*/
	public function update_users($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}
}
?>