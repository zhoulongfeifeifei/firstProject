<?php
namespace Admin\Controller;
use Think\Controller;
class WechatController extends WechatBaseController {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		//检查权限
		if(!checkMenuPermission('wechat_menu')){
			return ;
		}
		$wechat_model = D('wechat_menu');
		$condition = array();

		$total_rows = $wechat_model->get_menu_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$menu = $wechat_model->get_menu_list($condition,$offset,$per_page);
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$menu);
		$this->display();
	}

	/**
	*添加菜单
	*/
	public function add_menu(){
		//检查权限
		if(!checkPermission('add_menu')){
			return ;
		}
		$wechat_model = D('wechat_menu');
		if($_POST){
			$fid = I('post.fid',0,'intval');
			$sort = I('post.sort',0,'intval');
			$menu_name = I('post.menu_name','','trim');
			$type = I('post.type',0,'intval');
			$menu_content = I('post.menu_content','','trim');
			$status = I('post.status',0,'intval');
			$error = '';
			$data = array();
			if($type==0){
				$error = '请选择类型！';
			}
			if($status ==1){
				$condition = array('fid'=>$fid);
				$cknums = $wechat_model->check_menu_nums($condition);
				if($fid==0){
					if($cknums>=3){
						$error = '一级菜单个数最多为3个！';
					}
				}else if($cknums>=7){
					$error = '二级菜单个数最多为7个！';
				}
			}
			
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['fid'] = $fid;
				$data['sort'] = $sort;
				$data['menu_name'] = $menu_name;
				$data['menu_type'] = $type;
				$data['menu_content'] = $menu_content;
				$data['status'] = $status;
				$data['create_time'] = time();
				if(!$wechat_model->add_menu($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$msg = '添加成功';
					if(!$this->create_menu()){
						$msg = '本地添加成功，微信服务器失败！请联系管理员';
					}
					$r['statusCode'] = 200;
					$r['message'] = $msg;
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'menu_list';
				}
				
			}
			die(json_encode($r));

		}else{
			$condition = array('fid'=>0);
			$menu = $wechat_model->get_menu_list($condition);
			$this->assign('menu',$menu);
			$this->display();
		}
	}

	/**
	*添加菜单
	*/
	public function edit_menu(){
		//检查权限
		if(!checkPermission('edit_menu')){
			return ;
		}
		$menu_id = I('get.id',0,'intval');
		$wechat_model = D('wechat_menu');
		$info  = $wechat_model->get_menu_info(array('menu_id'=>$menu_id));
		if($_POST){
			$fid = I('post.fid',0,'intval');
			$sort = I('post.sort',0,'intval');
			$menu_name = I('post.menu_name','','trim');
			$type = I('post.type',0,'intval');
			$menu_content = I('post.menu_content','','trim');
			$status = I('post.status',0,'intval');
			$error = '';
			$data = array();
			if($type==0){
				$error = '请选择类型！';
			}
			if($status ==1){
				$condition = array('fid'=>$fid,'menu_id'=>array('neq',$menu_id));
				$cknums = $wechat_model->check_menu_nums($condition);
				if($fid==0){
					if($cknums>=3){
						$error = '一级菜单个数最多为3个！';
					}
				}else if($cknums>=7){
					$error = '二级菜单个数最多为7个！';
				}
			}
			
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['fid'] = $fid;
				$data['sort'] = $sort;
				$data['menu_name'] = $menu_name;
				$data['menu_type'] = $type;
				$data['menu_content'] = $menu_content;
				$data['status'] = $status;
				$data['update_time'] = time();
				if(!$wechat_model->update_menu(array('menu_id'=>$menu_id),$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$msg = '更新成功';
					if(!$this->create_menu()){
						$msg = '本地更新成功，微信服务器失败！请联系管理员';
					}
					$r['statusCode'] = 200;
					$r['message'] = $msg;
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'menu_list';
				}
				
			}
			die(json_encode($r));

		}else{
			$fmenu = $wechat_model->get_menu_info(array('menu_id'=>$info['fid']));
			$info['fname'] =$fmenu ?  $fmenu['menu_name'] : '一级菜单';
			$this->assign('menu',$info);
			$this->display();
		}
	}

	public function del_menu(){
		//检查权限
		if(!checkPermission('del_menu')){
			return ;
		}
		$wechat_model = D('wechat_menu');
		$menu_id = I('get.id',-1,'intval');
		if(!$wechat_model->delete_menu(array('menu_id'=>$menu_id))){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$msg = '删除成功';
			$wechat_model->delete_menu(array('fid'=>$menu_id));
			if(!$this->create_menu()){
				$msg = '本地删除成功，微信服务器失败！请联系管理员';
			}
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'menu_list';
		}
		die(json_encode($r));
	}

	/**
	* 创建菜单
	*/
	public function create_menu(){
		$wechat_model = D('wechat_menu');
		$access_token = $this->get_access_token();
		$api = C('CREATE_MENU_API').$access_token;
		$menu_first = $wechat_model->get_menu_list(array('fid'=>0,'status'=>1));
		$menu_arr = array();
		foreach($menu_first as $k=>$v){
			$menu = array();
			$menu_sec = $wechat_model->get_menu_list(array('fid'=>$v['menu_id'],'status'=>1));
			if($menu_sec){
				$menu['name'] = $v['menu_name'];
				$sec_arr = array();
				foreach($menu_sec as $m){
					$sec = array();
					$sec['name'] = $m['menu_name'];
					if($m['menu_type']==1){
						$sec['type'] = 'click';
						$sec['key'] = $m['menu_content'];
					}else{
						$sec['type'] = 'view';
						$sec['url'] = $m['menu_content'];
					}
					$sec_arr[]=$sec;
				}
				$menu['sub_button'] = $sec_arr;
			}else{
				$menu['name'] = $v['menu_name'];
				if($v['menu_type']==1){
					$menu['type'] = 'click';
					$menu['key'] = $v['menu_content'];
				}else{
					$menu['type'] = 'view';
					$menu['url'] = $v['menu_content'];
				}
			}
			$menu_arr[]=$menu;
		}
		$postData = array(
			'button'=>$menu_arr,
		);
		$postData =arrayToJsonUrlParam($postData);
		$res = json_decode(httpRequired($api,'',$postData,'POST'),true);
		if($res['errcode']==0){
			return true;
		}else{
			return false;
		}
	}
}