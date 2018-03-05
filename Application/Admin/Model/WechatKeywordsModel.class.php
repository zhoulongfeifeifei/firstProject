<?php
namespace Admin\Model;
use Think\Model;
class WechatKeywordsModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取列表
	*/
	public function get_keywords_list($condition=array(),$offset=0,$limit=20,$order='update_time DESC,create_time DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}

	/**
	*添加
	*/

	public function add_keywords($data=array()){
		return $this->add($data);
	}

	/**
	*获取总数
	*/

	public function get_keywords_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取信息
	*/
	public function get_keywords_info($condition=array()){
		return $this->where($condition)->find();
	}
		/**
	*修改
	*/
	public function update_keywords($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_keywords($condition=array()){
		return $this->where($condition)->delete();
	}

}
?>