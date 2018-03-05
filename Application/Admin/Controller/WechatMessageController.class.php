<?php
namespace Admin\Controller;
use Think\Controller;
class WechatMessageController extends WechatBaseController {

	public function __construct(){
		parent::__construct();
	}

	/**
	*消息列表
	*/
	public function index(){
		//检查权限
		if(!checkMenuPermission('receive_msg')){
			return ;
		}
		$wechat_message_model = D('wechat_message');
		$condition = array('from_type'=>0);

		$total_rows = $wechat_message_model->get_message_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$result = $wechat_message_model->get_message_list($condition,$offset,$per_page);
		foreach($result as &$value){
			if($value['type']==7){
				$info  = unserialize($value['otherinfo']);
				$value['Title'] = '标题：'.$info['Title'];
				$value['Description'] = '描述：'.$info['Description'];
			}
			$userinfo = D('wechat_users')->get_users_info(array('openid'=>$value['from']));
			$value['fromname'] = $userinfo  ? $userinfo['nickname'] : '';
			$value['fromimg'] = $userinfo ? $userinfo['headimgurl'] : '';
		}
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$result);
		$this->display();
	}


	/**
	* 关键词设置
	*/
	public function wechat_keywords(){
		//检查权限
		if(!checkMenuPermission('wechat_keywords')){
			return ;
		}
		$wechat_message_model = D('wechat_keywords');
		$words = I('post.words','','trim');
		$condition = array();
		if($words){
			$condition['words'] = array('like','%'.$words.'%');
		}
		$total_rows = $wechat_message_model->get_keywords_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$result = $wechat_message_model->get_keywords_list($condition,$offset,$per_page);
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$result);
		$this->display();
	}
	/**
	*添加菜单
	*/
	public function add_keywords(){
		//检查权限
		if(!checkPermission('add_keywords')){
			return ;
		}
		$wechat_model = D('wechat_keywords');
		if($_POST){
			$words = I('post.words','','trim');
			$status = I('post.status',0,'intval');
			if(!$words){
				$error = '关键词不能为空';
			}
			$ckwords = $wechat_model->get_keywords_info(array('words'=>$words));
			if($ckwords){
				$error = '关键词已经存在';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['words'] = $words;
				$data['status'] = $status;
				$data['create_time'] = time();
				if(!$wechat_model->add_keywords($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'wechat_keywords';
				}
				
			}
			die(json_encode($r));

		}else{
			$this->display();
		}
	}

	/**
	*添加菜单
	*/
	public function edit_keywords(){
		//检查权限
		if(!checkPermission('edit_keywords')){
			return ;
		}
		$id = I('get.id',0,'intval');
		$wechat_model = D('wechat_keywords');
		$info  = $wechat_model->get_keywords_info(array('id'=>$id));
		if($_POST){
			$words = I('post.words','','trim');
			$status = I('post.status',0,'intval');
			if(!$words){
				$error = '关键词不能为空';
			}
			$condition = array('words'=>$words,'id'=>array('neq',$id));
			$ckwords = $wechat_model->get_keywords_info($condition);
			if($ckwords){
				$error = '关键词已经存在';
			}
			
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['words'] = $words;
				$data['status'] = $status;
				$data['update_time'] = time();
				if(!$wechat_model->update_keywords(array('id'=>$id),$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '更新成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'wechat_keywords';
				}
				
			}
			die(json_encode($r));

		}else{
			$this->assign('info',$info);
			$this->display();
		}
	}

	public function del_keywords(){
		//检查权限
		if(!checkPermission('del_keywords')){
			return ;
		}
		$wechat_model = D('wechat_keywords');
		$id = I('get.id',-1,'intval');
		if(!$wechat_model->delete_keywords(array('id'=>$id))){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$msg = '删除成功';
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'wechat_keywords';
		}
		die(json_encode($r));
	}

	/**
	*被动回复
	*/

	public function revert_lists(){
		//检查权限
		if(!checkMenuPermission('revert_lists')){
			return ;
		}
		$wechat_message_model = D('wechat_message');
		$name = I('post.name','','trim');
		$condition = array();
		if($name){
			$condition['name'] = array('like','%'.$name.'%');
		}

		$total_rows = $wechat_message_model->get_revert_count($condition);
		$per_page = isset($_POST['numPerPage']) ? $_POST['numPerPage'] : C('PER_PAGE');
		$current_page = isset($_POST['pageNum']) ? $_POST['pageNum'] : 1;
		$offset = ($current_page - 1 ) * $per_page;

		$result = $wechat_message_model->get_revert_list($condition,$offset,$per_page);
	
		$this->assign('current_page',$current_page);
		$this->assign('total_rows',$total_rows);
		$this->assign('per_page',$per_page);
		$this->assign('result',$result);
		$this->display();	
	}

		/**
	*添加回复
	*/
	public function add_revert(){
		//检查权限
		if(!checkPermission('add_revert')){
			return ;
		}
		$wechat_message_model = D('wechat_message');
		if($_POST){
			$name = I('post.name','','trim');
			$type = I('post.type',0,'intval');
			$materialType = I('post.materialType',0,'intval');
			$material_id = I('post.material_id',0,'trim');
			$status = I('post.status',0,'intval');
			$keywords = I('post.keywords','','trim');
			$material_sort = I('post.material_sort','','trim');
			asort($material_sort);
			if(!$name){
				$error = '请输入名称！';
			}
			$ckname = $wechat_message_model->get_revert_info(array('name'=>$name));
			if($ckname){
				$error = '名称已经存在！';
			}
			if($type==-1){
				$error = '请选择接收消息的类型！';
			}
			if(!$material_id && $materialType!=6){
				$error = '请选择回复的消息内容！';
			}
			if($type==0){
				if(!$keywords){
					$error = '请选择关键词！';
				}
			}
			$ckres = $wechat_message_model->get_revert_info(array('receive_type'=>1,'status'=>1));
			if($ckres && $type==1&& $status==1){
				$error = '关注回复只能设置一次';
			}

			if($materialType==6 && !$material_sort){
				$error = '请选择回复内容！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['name'] = $name;
				$data['receive_type'] = $type;
				$data['revert_type'] = $materialType;
				if($materialType==6){
					$arr = array();
					$selected_id = explode(',', $material_id);
					foreach($material_sort as $k=>$v){
						if(in_array($k,$selected_id)){
							$arr[]=$k;
						}
					}
					$data['material_id'] = implode(',', $arr);
				}else{
					$data['material_id'] = $material_id;
				}
				if($type==0){
					$data['keywords_id'] =implode(',', $keywords);
				}
				$data['status'] = $status;
				$data['create_time'] = time();
				if(!$wechat_message_model->add_revert($data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '添加成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'revert_lists';
				}
				
			}
			die(json_encode($r));

		}else{
			//获取关键词列表
			$keywords = D('wechat_keywords')->get_keywords_list(array('status'=>1));
			$this->assign('keywords',$keywords);
			$this->display();
		}
	}
			/**
	*修改回复
	*/
	public function edit_revert(){
		//检查权限
		if(!checkPermission('edit_revert')){
			return ;
		}
		$wechat_message_model = D('wechat_message');
		$id = I('get.id','','trim');
		$info = $wechat_message_model->get_revert_info(array('id'=>$id));
		if($_POST){
			$name = I('post.name','','trim');
			$type = I('post.type',0,'intval');
			$materialType = I('post.materialType',0,'intval');
			$material_id = I('post.material_id',0,'trim');
			$status = I('post.status',0,'intval');
			$keywords = I('post.keywords','','trim');
			$material_sort = I('post.material_sort','','trim');
			asort($material_sort);

			if(!$name){
				$error = '请输入名称！';
			}
			$ckname = $wechat_message_model->get_revert_info(array('name'=>$name,'id'=>array('neq',$id)));
			if($ckname){
				$error = '名称已经存在！';
			}
			if($type==-1){
				$error = '请选择接收消息的类型！';
			}
			if(!$material_id && $materialType!=6){
				$error = '请选择回复的消息内容！';
			}
			if($type==0){
				if(!$keywords){
					$error = '请选择关键词！';
				}
			}
			$ckres = $wechat_message_model->get_revert_info(array('receive_type'=>1,'status'=>1,'id'=>array('neq',$id)));
			if($ckres && $type==1&& $status==1){
				$error = '关注回复只能设置一次';
			}
			if($materialType==6 && !$material_sort){
				$error = '请选择回复内容！';
			}
			if(!empty($error)) {
				$r['statusCode'] = 300;
				$r['message'] = $error;	
			} else {		
				$data['name'] = $name;
				$data['receive_type'] = $type;
				$data['revert_type'] = $materialType;
				if($materialType==6){
					$arr = array();
					$selected_id = explode(',', $material_id);
					foreach($material_sort as $k=>$v){
						if(in_array($k,$selected_id)){
							$arr[]=$k;
						}
					}
					$data['material_id'] = implode(',', $arr);
				}else{
					$data['material_id'] = $material_id;
				}
				if($type==0){
					$data['keywords_id'] =implode(',', $keywords);
				}
				$data['status'] = $status;
				$data['update_time'] = time();
				$where = array('id'=>$id);
				if(!$wechat_message_model->update_revert($where,$data)){
					$r['statusCode'] = 300;
					$r['message'] = '操作失败，请稍后重试！';
				}else{
					$r['statusCode'] = 200;
					$r['message'] = '更新成功';
					$r['callbackType'] = 'closeCurrent';
					$r['forwardUrl'] = '';
					$r['navTabId'] = 'revert_lists';
				}
				
			}
			die(json_encode($r));

		}else{
			//获取关键词列表
			$keywords = D('wechat_keywords')->get_keywords_list(array('status'=>1));
			$this->assign('keywords',$keywords);
			$this->assign('info',$info);
			$this->display();
		}
	}

	public function del_revert(){
		//检查权限
		if(!checkPermission('del_revert')){
			return ;
		}
		$wechat_message_model = D('wechat_message');
		$id = I('get.id',-1,'intval');
		if(!$wechat_message_model->delete_revert(array('id'=>$id))){
			$r['statusCode'] = 300;
			$r['message'] = '操作失败，请稍后重试！';
		}else{
			$msg = '删除成功';
			$r['statusCode'] = 200;
			$r['message'] = '删除成功';
			$r['callbackType'] = '';
			$r['forwardUrl'] = '';
			$r['navTabId'] = 'revert_lists';
		}
		die(json_encode($r));
	}


	/**
	* 回复消息
	*/

	public function revert_msg(){
		$openid = I('get.openid','','trim');
		$wechat_model = D('wechat_message');
		$result = array();
		$condition = " `from`='".$openid."' OR `to`='".$openid."' ";
		$res = $wechat_model->get_message_list($condition);
		$cnt = count($res);
		//最后一条消息id
		$new_id = $res ? $res[0]['id'] : 0;
		for($i=$cnt-1;$i>=0;$i--){
			$result[]=$res[$i];
		}

		$users_model = D('wechat_users');
		$condition = array('openid'=>$openid);
		$info = $users_model->get_users_info($condition);
		if($info){
			$where = array('from'=>$openid);
			$wechat_model->update_message($where,array('is_read'=>1));
			D('wechat_users')->update_users(array('openid'=>$openid),array('no_read_msg'=>0));
		}
		$this->assign('new_msg_id',$new_id);
		$this->assign('info',$info);
		$this->assign('message',$result);
		$this->display();
	}

	/**
	* 回复消息
	* @param type  消息类型
	* @param content   消息内容   
	* @param  openid  用户id
	* @param sendtype  消息发送途径  1  素材  0 文本内容
	*/
	public function send_msg(){
		$type=I('get.type',1,'intval');
		$content = I('post.content','','trim');
		$openid = I('post.openid','','trim');
		$sendtype=I('post.sendtype',0,'intval');

		$postData = array();
		$result = array('status'=>0);
		$wechat_model = D('wechat_message');
		$wechat_material_model = D('wechat_material');

		$materialData = array();
		if($sendtype==1){
			$condition = array('status'=>1,'id'=>array('in',$content));
			if($type==6){
				$materialData = $wechat_material_model->get_material_list($condition);
			}else{
				$materialData = $wechat_material_model->get_material_info($condition);
				$materialData['contenturl'] = trim($materialData['contenturl'],'.');
				$materialData['medialoc'] = trim($materialData['medialoc'],'.');
			}
		}

		//图文时候排序
		$material_sort = array();
		$news = array();
		if($type==6){   //图文消息排序
			$sort_val = I('post.sort_val','','trim');
			$sort_arr = explode(',', $sort_val);
			foreach($sort_arr as $v){
				if(!empty($v)){
					$strArr = explode('|', $v);
					$material_sort[$strArr[0]] =$strArr[1];
					$news[]=$strArr[0];
				}
			}
			asort($material_sort);
			$content = implode(',', $news);
		}

		$postData['touser'] = $openid;
		switch($type){
			case 1:
				$postData['msgtype'] = 'text';
				if($sendtype==1){  //通过素材选择
					$postData['text'] = array('content'=>$materialData['content']);
					$content = $materialData['content'];
				}else{
					$postData['text'] = array('content'=>$content);
				}
				break;
			case 2:
				$postData['msgtype'] = 'image';
				$postData['image'] = array('media_id'=>$materialData['mediaid']);
				break;
			case 3:
				$postData['msgtype'] = 'voice';
				$postData['voice'] = array('media_id'=>$materialData['mediaid']);
				break;
			case 4:
				$postData['msgtype'] = 'video';
				$postData['video'] = array(
					'media_id'=>$materialData['mediaid'],
					'title'=>$materialData['title'],
					'description'=>$materialData['description'],
				);
				break;
			case 5:
				$postData['msgtype'] = 'music';
				$postData['music'] = array(
					'title'=>$materialData['title'],
					'description'=>$materialData['description'],
					'musicurl'=>$materialData['url'],
					'hqmusicurl'=>$materialData['contenturl'],
				);
				break;
			case 6:
				$newsArr = array();
				foreach($material_sort as $mid=>$sort){
					foreach($materialData as &$value){
						if($value['id'] == $mid){
							$newsArr[] = array(
								'title'=>$value['title'],
								'description'=>$value['description'],
								'url'=>$value['url'],
								'picurl'=>$value['contenturl'],
							);
						}
						$value['contenturl'] = trim($value['contenturl'],'.');
						$value['medialoc'] = trim($value['medialoc'],'.');
					}
				}
				$postData['msgtype'] = 'news';
				$postData['news'] = array(
					'articles'=>$newsArr,
				);
				break;
		}
		$res = $this->send_serivce($postData);
		if($res['errcode']==0){
			$result['status'] = 1;
			$insertArr = array(
				'to'=>$openid,
				'type'=>$type,
				'content'=>$content,
				'create_time'=>time(),
				'is_read'=>1,
				'from_type'=>1,
			);
			$insert_id = $wechat_model->add_message($insertArr);
			$result['msg_id'] = $insert_id;
			$result['create_time'] = date('m-d H:i');
			//更新已读消息
			$where = array('from'=>$openid,'id'=>array('lt',$insert_id));
			$wechat_model->update_message($where,array('is_read'=>1));
		}else{
			$result['msg'] = C('WECHAT_CODE')[$res['errcode']] ? C('WECHAT_CODE')[$res['errcode']] : $res['errmsg'];
		}
		$result['type'] = $type;
		if($type==1){
			$result['content'] = replaceEmoji($content);
		}else{
			$result['content'] = $materialData;
		}

		die(json_encode($result)); 
	}

	public function get_message_byid(){
		$msg_id = I('get.msg_id',0,'intval');
		$openid = I('post.openid','','trim');
		$wechat_model = D('wechat_message');
		if(!$msg_id){
			$result['status'] = 0;
		}else{
			$condition=array('from'=>$openid,'id'=>array('gt',$msg_id));
			$res = $wechat_model->get_message_list($condition);
			$cnt = count($res);
			$result = array();
			for($i=$cnt-1;$i>=0;$i--){
				$result['lists'][]=$res[$i];
			}
			foreach($result['lists'] as $k=>&$v){
				switch($v['type']){
					case 1:
						$v['content'] = replaceEmoji($v['content']);
						break;
					case 2:
						$v['content'] = '<img src="'.$v['medialoc'].'" height="120px;"/>';
						break;
					case 3:
						$v['content'] = '<audio controls="controls" height="40px"><source src="'.trim($v['medialoc'],'.').'" />无法播放</audio>';
						break;
					 case 4:
						 $v['content'] = '<video src="'.trim($v['medialoc'],'.').'" controls="controls" height="180px">加载失败或者资源错误</video>';
						 break;
					 case 5:
						//小视频
						$v['content'] = '<video src="'.trim($v['medialoc'],'.').'" autoplay="autoplay" loop="loop" height="180px">加载失败或者资源错误</video>';
						 break;
					 case 6:
						$v['content'] = '地理位置：'.$v['content'];
						 break;
					 case 7:
						$otherInfo = unserialize($v['otherinfo']);
						$v['content'] = '<a href="'.$v['content'].'" target="_blank"><b>链接：</b>'.$otherInfo['Title'].'</a>';
						break;
				}
				$v['create_time'] = date('m-d H:i',$v['create_time']);
				$upwhere = array('id'=>$v['id']);
				$wechat_model->update_message($upwhere,array('is_read'=>1));
			}
			if($res){
				$result['status'] = 1;
				D('wechat_users')->update_users(array('openid'=>$openid),array('no_read_msg'=>0));
			}else{
				$result['status'] = 0;
			}
		}
		die(json_encode($result));
	}
}