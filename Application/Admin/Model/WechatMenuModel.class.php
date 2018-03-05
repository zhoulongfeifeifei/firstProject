<?php
namespace Admin\Model;
use Think\Model;
class WechatMenuModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取列表
	*/
	public function get_menu_list($condition=array(),$offset=0,$limit=20,$order='fid ASC,sort ASC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	public function check_menu_nums($condition=array()){
		$res = $this->where($condition)->field('menu_id')->select();
		return count($res);
	}

	/**
	*添加
	*/

	public function add_menu($data=array()){
		return $this->add($data);
	}

	/**
	*获取总数
	*/

	public function get_menu_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

	/**
	*获取信息
	*/
	public function get_menu_info($condition=array()){
		return $this->where($condition)->find();
	}
		/**
	*修改
	*/
	public function update_menu($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_menu($condition=array()){
		return $this->where($condition)->delete();
	}

}
?>