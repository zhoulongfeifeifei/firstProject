<?php
namespace Admin\Model;
use Think\Model;
class WechatMessageModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	*获取列表
	*/
	public function get_message_list($condition=array(),$offset=0,$limit=20,$order='create_time DESC'){
		return $this->where($condition)->limit($offset,$limit)->order($order)->select();
	}


	public function check_menu_nums($condition=array()){
		$res = $this->where($condition)->field('menu_id')->select();
		return count($res);
	}

	/**
	*获取总数
	*/

	public function get_message_count($condition=array()){
		$res = $this->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

		/**
	*修改
	*/
	public function update_revert($condition=array(),$data=array()){
		return M()->table('p_wechat_message_revert')->where($condition)->save($data);
	}

	/**
	* 删除
	*/
	public function delete_revert($condition=array()){
		return M()->table('p_wechat_message_revert')->where($condition)->delete();
	}


		/**
	*获取回复列表
	*/
	public function get_revert_list($condition=array(),$offset=0,$limit=20,$order='create_time DESC'){
		return M()->table('p_wechat_message_revert')->where($condition)->limit($offset,$limit)->order($order)->select();
	}

		/**
	*获取信息
	*/
	public function get_revert_info($condition=array()){
		return M()->table('p_wechat_message_revert')->where($condition)->find();
	}

		/**
	*添加回复
	*/

	public function add_revert($data=array()){
		return M()->table('p_wechat_message_revert')->add($data);
	}

	/**
	*获取总数
	*/

	public function get_revert_count($condition=array()){
		$res =  M()->table('p_wechat_message_revert')->where($condition)->field('count(*) AS cnt')->find();
		return isset($res['cnt']) ? $res['cnt'] : 0;
	}

		/**
	*添加
	*/

	public function add_message($data=array()){
		return $this->add($data);
	}

			/**
	*修改
	*/
	public function update_message($condition=array(),$data=array()){
		return $this->where($condition)->save($data);
	}
}
?>