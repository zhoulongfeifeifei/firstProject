<?php
namespace Admin\Controller;
use Think\Controller;
class WechatUsersController extends WechatBaseController {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		//检查权限
		if(!checkMenuPermission('wechat_users')){
			return ;
		}
		$wechat_model = D('wechat_users');
		$wechat_message_model = D('wechat_message');
		$nickname = I('post.nickname','','trim');
		$condition = array();
		if($nickname){
			$condition['nickname'] = array('like','%'.$nickname.'%');
		}

		$total_rows = $wechat_model->get_users_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$res = $wechat_model->get_users_list($condition,$offset,$per_page);
		foreach($res as $k=>$v){
			if($v['qrcode_time']+(30*24*3600)<=time() && $v['qrcode_type']==1 ){
				$this->create_qrcode($v['openid'],$v['id']);
			}
		}
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$res);
		$this->display();
	}

}